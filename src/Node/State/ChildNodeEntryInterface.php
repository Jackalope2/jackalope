<?php

namespace Jackalope2\Node\State;

/**
 * A {@code ChildNodeEntryInterface} instance represents the child node states of a
 * {@link NodeStateInterface}.
 * <h2>Equality and hash codes</h2>
 *
 * Two child node entries are considered equal if and only if their names
 * and referenced node states match.
 */
interface ChildNodeEntryInterface
{
    /**
     * The name of the child node state wrt. to its parent state.
     *
     * @return string name of the child node
     */
    public function getName();

    /**
     * The child node state
     *
     * @return NodeStateInterface child node state
     */
    public function getNodeState();
}
