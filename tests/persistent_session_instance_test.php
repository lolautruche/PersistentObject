<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Test the instance class
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionInstanceTest extends ezcTestCase
{
    private $default;

    public function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }
    }

    public function tearDown()
    {
    }

    public function testGetWithIdentifierValid()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $session1 = new ezcPersistentSession( ezcDbInstance::get(), $manager );
        $manager2 = clone( $manager );
        $manager2->a = "something";
        $session2 = new ezcPersistentSession( ezcDbInstance::get(), $manager2 );

        ezcPersistentSessionInstance::set( $session1 );
        ezcPersistentSessionInstance::set( $session2, 'secondary' );
        $this->assertEquals( false, isset( ezcPersistentSessionInstance::get()->definitionManager->a ) );
        $this->assertEquals( true, isset( ezcPersistentSessionInstance::get( 'secondary' )->definitionManager->a ) );
    }

    public function testChooseDefault()
    {

        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $session1 = new ezcPersistentSession( ezcDbInstance::get(), $manager );
        $manager2 = clone( $manager );
        $manager2->a = "something";
        $session2 = new ezcPersistentSession( ezcDbInstance::get(), $manager2 );

        ezcPersistentSessionInstance::set( $session1 );
        ezcPersistentSessionInstance::set( $session2, 'secondary' );
        ezcPersistentSessionInstance::chooseDefault( 'secondary' );
        $this->assertEquals( true, isset( ezcPersistentSessionInstance::get()->definitionManager->a ) );
    }

    public function testWithIdentifierInvalid()
    {
        try
        {
            ezcPersistentSessionInstance::get( "NoSuchInstance" );
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcPersistentSessionNotFoundException $e ) {}
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcPersistentSessionInstanceTest" );
    }
}

?>