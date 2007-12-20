<?php
/**
 * File containing the ezcPersistentObjectPropertyDateTimeConversion class.
 *
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package PersistentObject
 */

/**
 * Property conversion class for date/time values.
 *
 * An instance of this class can be used with {@link
 * ezcPersistentObjectProperty} in a {@link ezcPersistentObjectDefinition} to
 * indicate, that a database date/time value (represented by a unix timestamp
 * integer value) should be converted to a PHP DateTime object.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentObjectPropertyDateTimeConversion
{
    /**
     * Converts unix timestamp to DateTime instance.
     *
     * This method is called right after a column value has been read from the
     * database, given the $databaseValue. The value returned by this method is
     * then assigned to the persistent objects property.
     *
     * The given integer value $databaseValue is handled as a date/time value
     * in unix timestamp representation. A corresponding DateTime object is
     * returned, representing the same date/time value.
     * 
     * @param int $databaseValue 
     * @return DateTime
     *
     * @throws ezcBaseValueException
     *         if the given $databaseValue is not an integer.
     */
    public function fromDatabase( $databaseValue )
    {
        if ( !is_int( $databaseValue ) && !is_numeric( $databaseValue ) )
        {
            throw new ezcBaseValueException( 'databaseValue', $databaseValue, 'int' );
        }
        return new DateTime( '@' . (int) $databaseValue );
    }

    /**
     * Converts a DateTime object into a unix timestamp.
     *
     * This method is called right before a property value is written to the
     * database, given the $propertyValue. The value returned by this method is
     * then written back to the database.
     *
     * The method expects a DateTime object in $propertyValue and returns the
     * date/time value represented by it as an integer value in unix timestamp
     * format.
     * 
     * @param DateTime $propertyValue 
     * @return int
     *
     * @throws ezcBaseValueException
     *         if the given $propertyValue is not an instance of DateTime.
     */
    public function toDatabase( $propertyValue )
    {
        if ( !( $propertyValue instanceof DateTime ) )
        {
            throw new ezcBaseValueException( 'propertyValue', $propertyValue, 'DateTime' );
        }
        return $propertyValue->format( 'U' );
    }
}

?>
