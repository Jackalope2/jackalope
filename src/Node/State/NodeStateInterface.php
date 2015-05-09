<?php

namespace Jackalope2\Node\State;

use Jackalope2\Exception\InvalidArgumentException;

interface NodeStateInterface extends BaseNodeStateInterface
{
    /**
     * Returns the <em>iterable</em> child node entries of this instance.
     * Multiple iterations are guaranteed to return the child nodes in
     * the same order, but the specific order used is implementation
     * dependent and may change across different states of the same node.
     * <p>
     * <i>Note on cost and performance:</i> while it is possible to iterate over
     * all child {@code NodeState}s with the two methods {@link
     * #getChildNodeNames()} and {@link #getChildNode(String)}, this method is
     * considered more efficient because an implementation can potentially
     * perform the retrieval of the name and {@code NodeState} in one call.
     * This results in O(n) vs. O(n log n) when iterating over the child node
     * names and then look up the {@code NodeState} by name.
     *
     * @return \Iterator node entries in some stable order
     */
    public function getChildNodeEntries();

    /**
     * Returns a builder for constructing a new node state based on
     * this state, i.e. starting with all the properties and child nodes
     * of this state.
     *
     * @return NodeBuilderInterface Node builder based on this state
     */
    public function builder();

    /**
     * Compares this node state against the given base state. Any differences
     * are reported by calling the relevant added/changed/deleted methods of
     * the given handler.
     *
     * TODO: Define the behavior of this method with regards to
     * iterability/existence of child nodes.
     *
     * @param NodeStateInterface $base base state
     * @param NodeStateDiffInterface $diff handler of node state differences
     *
     * @return {@code true} if the full diff was performed, or
     *         {@code false} if it was aborted as requested by the handler
     *         (see the {@link NodeStateDiffInterface} contract for more details)
     */
    public function compareAgainstBaseState(NodeState base, NodeStateDiff diff);
}
