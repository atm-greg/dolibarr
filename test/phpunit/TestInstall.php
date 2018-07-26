<?php
/* Copyright (C) 2010-2012  Laurent Destailleur <eldy@users.sourceforge.net>
 * Copyright (C) 2011-2012  Regis Houssin       <regis.houssin@capnetworks.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * or see http://www.gnu.org/
 */

/**
 *      \file       test/phpunit/AllTest.php
 *      \ingroup    test
 *      \brief      This file is a test suite to run all unit tests
 *      \remarks    To run this script as CLI:  phpunit filename.php
 */
print "PHP Version: ".phpversion()."\n";
print "Memory: ". ini_get('memory_limit')."\n";

global $conf,$user,$langs,$db;
//define('TEST_DB_FORCE_TYPE','mysql'); // This is to force using mysql driver
//require_once 'PHPUnit/Autoload.php';
require_once dirname(__FILE__).'/../../htdocs/master.inc.php';
print 'DOL_MAIN_URL_ROOT='.DOL_MAIN_URL_ROOT."\n";  // constant will be used by other tests


if ($langs->defaultlang != 'en_US')
{
    print "Error: Default language for company to run tests must be set to en_US or auto. Current is ".$langs->defaultlang."\n";
    exit(1);
}
if (empty($conf->adherent->enabled))
{
    print "Error: Module member must be enabled to have significant results.\n";
    exit(1);
}
if (! empty($conf->ldap->enabled))
{
    print "Error: LDAP module should not be enabled.\n";
    exit(1);
}
if (! empty($conf->google->enabled))
{
    print "Warning: Google module should not be enabled.\n";
}
if (empty($user->id))
{
    print "Load permissions for admin user nb 1\n";
    $user->fetch(1);
    $user->getrights();
}
$conf->global->MAIN_DISABLE_ALL_MAILS=1;



/**
 * Class for the All test suite
 */
class AllTests
{
    /**
     * Function suite to make all PHPUnit tests
     *
     * @return	void
     */
    public static function suite()
    {
        
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit Framework');
        
        //require_once dirname(__FILE__).'/CoreTest.php';
        //$suite->addTestSuite('CoreTest');
        require_once dirname(__FILE__).'/InstallTest.php';
        $suite->addTestSuite('InstallTest');
                
        return $suite;
    }
}

