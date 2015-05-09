<?php

namespace Jackalope2\Node\State;

use Jackalope2\Node\State\BaseNodeStateInterface;
use Jackalope2\Exception\InvalidArgumentException;
use Jackalope2\Node\State\NodeBuilderInterface;

/**
 * Builder interface for constructing new {@link NodeStateInterface node states}.
 * <p>
 * A node builder can be thought of as a mutable version of a node state.
 * In addition to property and child node access methods like the ones that
 * are already present in the NodeState interface, the {@code NodeBuilder}
 * interface contains the following key methods:
 * <ul>
 * <li>The {@code setProperty} and {@code removeProperty} methods for
 *     modifying properties</li>
 * <li>The {@code getChildNode} method for accessing or modifying an existing
 *     subtree</li>
 * <li>The {@code setChildNode} and {@code removeChildNode} methods for adding,
 *     replacing or removing a subtree</li>
 * <li>The {@code exists} method for checking whether the node represented by
 *     a builder exists or is accessible</li>
 * <li>The {@code getNodeState} method for getting a frozen snapshot of the
 *     modified content tree</li>
 * </ul>
 * All the builders acquired from the same root builder instance are linked so
 * that changes made through one instance automatically become visible in the other
 * builders. For example:
 * <pre>
 *     $rootBuilder = root.builder();
 *     $fooBuilder = rootBuilder.getChildNode("foo");
 *     $barBuilder = fooBuilder.getChildNode("bar");
 *
 *     var_dump($barByuilder->getBoolean('x')) // false
 *     $fooBuilder->getChildNode("bar")->setProperty('x', true);
 *     var_dump($barBuilder->getBoolean('x')) // true
 *
 *     var_dump($barBuilder->exists()); // true
 *     $fooBuilder->removeChildNode("bar");
 *     var_dump($barBuilder->exists()); // false
 * </pre>
 * The {@code getNodeState} method returns a frozen, immutable snapshot of the current
 * state of the builder. Providing such a snapshot can be somewhat expensive especially
 * if there are many changes in the builder, so the method should generally only be used
 * as the last step after all intended changes have been made. Meanwhile the accessors
 * in the {@code NodeBuilder} interface can be used to provide efficient read access to
 * the current state of the tree being modified.
 * <p>
 * The node states constructed by a builder often retain an internal reference to the base
 * state used by the builder. This allows common node state comparisons to perform really.
 */
interface NodeBuilderInterface extends BaseNodeStateInterface
{
    /**
     * Returns an immutable node state that matches the current state of
     * the builder.
     *
     * @return NodeStateInterface immutable node state
     */
    public function getNodeState();

    /**
     * Returns the original base state that this builder is modifying.
     * The return value may be non-existent (i.e. its {@code exists} method
     * returns {@code false}) if this builder represents a new node that
     * didn't exist in the base content tree.
     *
     * @return NodeStateInterface node state, possibly non-existent
     */
    public function getBaseState();

    /**
     * Check whether this builder represents a new node, which is not present in the base state.
     *
     * @return bool {@code true} for a new node
     */
    public function isNew();

    /**
     * Check whether the named property is new, i.e. not present in the base state.
     *
     * @param $name property name
     * @return bool {@code true} for a new property
     */
    public function isPropertyNew($name);

    /**
     * Check whether this builder represents a modified node, which has either modified properties
     * or removed or added child nodes.
     *
     * @return bool  {@code true} for a modified node
     */
    public function isModified();

    /**
     * Check whether this builder represents a node that used to exist but
     * was then replaced with other content, for example as a result of
     * a {@link #setChildNode(String)} call.
     *
     * @return bool {@code true} for a replaced node
     */
    public function isReplaced();

    /**
     * Check whether the named property exists in the base state but is
     * replaced with other content, for example as a result of
     * a {@link #setProperty(PropertyState)} call.
     *
     * @param $name property name
     * @return bool {@code true} for a replaced property
     */
    public function isPropertyReplaced($name);

    /**
     *
     * @param $max the maximum value
     * @return int number of child nodes
     */
    public function getChildNodeCount($max);

    /**
     * Returns a builder for constructing changes to the named child node.
     * If the named child node does not already exist, a new empty child
     * node is automatically created as the base state of the returned
     * child builder. Otherwise the existing child node state is used
     * as the base state of the returned builder.
     * <p>
     * All updates to the returned child builder will implicitly affect
     * also this builder, as if a
     * {@code setNode(name, childBuilder.getNodeState())} method call
     * had been made after each update. Repeated calls to this method with
     * the same name will return the same child builder instance until an
     * explicit {@link #setChildNode(String, NodeState)} or
     * {@link #remove()} call is made, at which point the link
     * between this builder and a previously returned child builder for
     * that child node name will get broken.
     *
     * @param $name name of the child node
     * @return NodeBuilderInterface Child builder
     * @throws InvalidArgumentException if the given name string is empty
     *                                  or contains the forward slash character
     */
    public function child($name);

    /**
     * Returns a builder for constructing changes to the named child node.
     * If the named child node does not already exist, the returned builder
     * will refer to a non-existent node and trying to modify it will cause
     * {@link IllegalStateException}s to be thrown.
     *
     * @param $name name of the child node
     * @return NodeBuilderInterface child builder, possibly non-existent
     * @throws InvalidArgumentException if the given name string is empty
     *                                  or contains the forward slash character
     */
    public function getChildNode($name);

    /**
     * Adds the named child node and returns a builder for modifying it.
     * Possible previous content in the named subtree is removed.
     *
     * If a NodeState is passed as a second argument then the subtree will
     * be replaced with the given node state.
     *
     * @param $name name of the child node
     * @return NodeBuilderInterface child builder
     * @throws IllegalArgumentException if the given name string is empty
     *                                  or contains the forward slash character
     */
    public function setChildNode($name, NodeStateInterface $nodeState = null);

    /**
     * Remove this child node from its parent.
     *
     * @return boolean {@code true} for existing nodes, {@code false} otherwise
     */
    public function remove();

    /**
     * Move this child to a new parent with a new name. When the move succeeded this
     * builder has been moved to {@code newParent} as child {@code newName}. Otherwise neither
     * this builder nor {@code newParent} are modified.
     * <p>
     * The move succeeds if both, this builder and {@code newParent} exist, there is no child with
     * {@code newName} at {@code newParent} and {@code newParent} is not in the subtree of this
     * builder.
     * <p>
     * The move fails if the this builder or {@code newParent} does not exist or if there is
     * already a child {@code newName} at {@code newParent}.
     * <p>
     * For all remaining cases (e.g. moving a builder into its own subtree) it is left
     * to the implementation whether the move succeeds or fails as long as the state of the
     * involved builder stays consistent.
     *
     * @param $newParent  builder for the new parent.
     * @param $newName  name of this child at the new parent
     * @return boolean {@code true} on success, {@code false} otherwise
     * @throws InvalidArgumentException if the given name string is empty
     *                                  or contains the forward slash character
     */
    public function moveTo(NodeBuilderInterface $newParent, $newName);

    /**
     * Set a property state
     *
     * @param PropertyStateInterface  The property state to set
     * @return NodeBuilderInterface this builder
     * @throws InvalidArgumentException if the property name is empty
     *                                  or contains the forward slash character
     */
    public function setPropertyState(PropertyStateInterface $property);

    /**
     * Set a property state
     *
     * @param string $name  The name of this property
     * @param string $value  The value of this property
     * @param int $type The type of this property. Must be one of the PHPCR\PropertyType:: constants
     * @throws InvalidArgumentException if the type of the value is not one of the above types, or if the property name is empty or contains the forward slash character
     * @return NodeBuilderInterface this builder
     */
    public function setProperty($name, $value, $type = null);

    /**
    * Remove the named property. This method has no effect if a
    * property of the given {@code name} does not exist.
    *
    * @param $name  name of the property
    */
    public function removeProperty($name);

    /**
     * Create a blog
     *
     * @param stream $stream
     *
     * @throws IOException
     */
    public function createBlob($stream);
}
