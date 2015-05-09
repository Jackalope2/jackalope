<?php

namespace Jackalope2\Node;

use Jackalope2\Exception\NumberFormatException;
use Jackalope2\Exception\UnsupportedOperationException;

/**
 *
 * Immutable property state. A property consists of a name and a value.
 * A value is either an atom or an array of atoms.
 *
 * <h2>Equality and hash codes</h2>
 * <p>
 * Two property states are considered equal if and only if their names and
 * values match. The {@link Object#equals(Object)} method needs to
 * be implemented so that it complies with this definition. And while
 * property states are not meant for use as hash keys, the
 * {@link Object#hashCode()} method should still be implemented according
 * to this equality contract.
 */
interface PropertyState
{
    /**
     * @return string the name of this property state
     */
    public function getName();

    /**
     * Determine whether the value is an array of atoms
     *
     * @return bool {@code true} if and only if the value is an array of atoms.
     */
    public function isArray();

    /**
     * Determine the type of this property.
     *
     * One of the PHPCR\PropertyType constant values
     *
     * @return int the type of this property
     */
    public function getType();

    /**
     * Value of this property.
     * The type of the return value is determined by the target {@code type}
     * argument. If {@code type.isArray()} is true, this method returns an
     * {@code Iterable} of the {@link Type#getBaseType() base type} of
     * {@code type} containing all values of this property.
     * If the target type is not the same as the type of this property an attempt
     * is made to convert the value to the target type. If the conversion fails an
     * exception is thrown. The actual conversions which take place are those defined
     * in the {@link org.apache.jackrabbit.oak.plugins.value.Conversions} class.
     * @param $type target type
     * @return mixed the value of this property
     * @throws InvalidArgumentException  if {@code type} refers to an unknown type.
     * @throws NumberFormatException  if conversion to a number failed.
     * @throws UnsupportedOperationException  if conversion to boolean failed.
     * @throws OutOfRangeException If the index is less than zero or otherwise does not exist
     */
    public function getValue($type = null, $index = null);

    /**
     * The size of the value of this property.
     * @param $index
     * @return size of the value (optionally at the given {@code index}).
     * @throws OutOfRangeException If {@code index} is less than {@code 0} or
     *         greater or equals {@code count()}.
     */
    public function getSize($index = null);

    /**
     * The number of values of this property. {@code 1} for atoms.
     * @return integer number of values
     */
    public function count();
}
