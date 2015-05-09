<?php

namespace Jackalope2\Node\State;

/**
 * Storage abstraction for trees. At any given point in time the stored
 * tree is rooted at a single immutable node state.
 *
 * This is a low-level interface that doesn't cover functionality like
 * merging concurrent changes or rejecting new tree states based on some
 * higher-level consistency constraints.
 */
interface NodeStoreInterface
{
    /**
     * Returns the latest state of the tree
     *
     * @return NodeStateInterface
     */
    public function getRoot();

    /**
     * Merges the changes between the
     * {@link NodeBuilderInterface#getBaseState() base} and
     * {@link NodeBuilderInterface#getNodeState() head} states
     * of the given builder to this store.
     *
     * @param builder the builder whose changes to apply
     * @param commitHook the commit hook to apply while merging changes
     * @param info commit info associated with this merge operation
     *
     * @return the node state resulting from the merge.
     *
     * @throws CommitFailedException if the merge failed
     * @throws IllegalArgumentException if the builder is not acquired
     */
    public function merge(NodeBuilderInterface $nodeBuilder, CommitHookInterface $commitHook);
}
