<?php

namespace Jackalope2\Node\State;

use Jackalope2\Exception\InvalidArgumentException;

interface BaseNodeStateInterface
{
    /**
     * Return true if the node exists
     *
     * @return boolean True if this node exists, False if not
     */
    public function exists();

    /**
     * Checks whether the named property exists. The implementation is
     * equivalent to {@code getProperty(name) != null}, but may be optimized
     */
    public function getProperty($name);

    /**
     * Returns the boolean value of the named property. The implementation
     * is equivalent to the following code, but may be optimized.
     *
     * <pre>
     * PropertyState property = state.getProperty(name);
     * return property != null
     *     && property.getType() == Type.BOOLEAN
     *     && property.getValue(Type.BOOLEAN);
     * </pre>
     *
     * @param $name Property name
     * @return boolean Balue of the named property, or {@code false}
     */
    public function getBoolean($name);

    /**
     * Returns the long value of the named property. The implementation
     * is equivalent to the following code, but may be optimized.
     * <pre>
     * PropertyState property = state.getProperty(name);
     * if (property != null && property.getType() == Type.LONG) {
     *     return property.getValue(Type.LONG);
     * } else {
     *     return 0;
     * }
     * </pre>
     *
     * @param $name Property name
     * @return int Balue of the named property, or zero
     */
    public function getLong($name);


    /**
     * Returns the string value of the named property. The implementation
     * is equivalent to the following code, but may be optimized.
     * <pre>
     * PropertyState property = state.getProperty(name);
     * if (property != null && property.getType() == Type.STRING) {
     *     return property.getValue(Type.STRING);
     * } else {
     *     return null;
     * }
     * </pre>
     *
     * @param $name Property name
     * @return string value of the named property, or {@code null}
     */
    public function getString($name);

    /**
     * Returns the string values of the named property. The implementation
     * is equivalent to the following code, but may be optimized.
     * <pre>
     * PropertyState property = state.getProperty(name);
     * if (property != null && property.getType() == Type.STRINGS) {
     *     return property.getValue(Type.STRINGS);
     * } else {
     *     return Collections.emptyList();
     * }
     * </pre>
     *
     * @param $name property name
     *
     * @return string[] Values of the named property, or an empty array
     */
    public function getStrings($name);

    /**
     * Returns the name value of the named property. The implementation
     * is equivalent to the following code, but may be optimized.
     * <pre>
     * PropertyState property = state.getProperty(name);
     * if (property != null && property.getType() == Type.NAME) {
     *     return property.getValue(Type.NAME);
     * } else {
     *     return null;
     * }
     * </pre>
     *
     * @param $name property name
     * @return string Value of the named property, or {@code null}
     */
    public function getName($name);

    /**
     * Returns the name values of the named property. The implementation
     * is equivalent to the following code, but may be optimized.
     * <pre>
     * PropertyState property = state.getProperty(name);
     * if (property != null && property.getType() == Type.NAMES) {
     *     return property.getValue(Type.NAMES);
     * } else {
     *     return Collections.emptyList();
     * }
     * </pre>
     *
     * @param $name property name
     * @return string[] values of the named property, or an empty collection
     */
    public function getNames($name);

    /**
     * Returns the number of properties of this node.
     *
     * @return int Number of properties
     */
    public function getPropertyCount();

    /**
     * Returns an iterable of the properties of this node. Multiple
     * iterations are guaranteed to return the properties in the same
     * order, but the specific order used is implementation-dependent
     * and may change across different states of the same node.
     *
     * @return properties in some stable order
     */
    public function getProperties();

    /**
     * Checks whether the named child node exists. The implementation
     * is equivalent to {@code getChildNode(name).exists()}, except that
     * passing an invalid name as argument will result in a {@code false}
     * return value instead of an {@link IllegalArgumentException}.
     *
     * @param $name name of the child node
     * @return {@code true} if the named child node exists,
     *         {@code false} otherwise
     */
    public function hasChildNode($name);

    /**
     * Returns the named, possibly non-existent, child node. Use the
     * {@link #exists()} method on the returned child node to determine
     * whether the node exists or not.
     *
     * @param name name of the child node to return
     * @return named child node
     * @throws InvalidArgumentException if the given name string is is empty
     *                                  or contains a forward slash character
     */
    public function getChildNode($name);

    /**
     * Returns the number of <em>iterable</em> child nodes of this node.
     * <p>
     * If an implementation knows the exact value, it returns it (even if
     * the value is higher than max). If the implementation does not know the
     * exact value, and the child node count is higher than max, it may return
     * PHP_INT_MAX. 
     *
     * The cost of the operation is at most O(max).
     * 
     * @param $max the maximum number of entries to traverse
     * @return number of iterable child nodes
     */
    public function getChildNodeCount($max);

    /**
     * Returns the names of all <em>iterable</em> child nodes.
     *
     * @return string[] child node names in some stable order
     */
    public function getChildNodeNames();
}

