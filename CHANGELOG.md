Change Log
=====

# 0.2.1
- Require item class name to be provided via abstract method `getItemClassName()` instead of via the collection constructor.
- Removed support for `ArrayAccess`, and replicate functionality via more meaningful methods such as `Collection::has()` and `Collection::get()`.
- Added the factory methods `Collection::from()` and `Collection::empty()`.
- Added helper methods `Collection::isEmpty()` and `Collection::isNotEmpty()`.
- Added `Collection::reverse()` helper to reverse the order of the collection.

# 0.2.0
- Minimum PHP version bumped to 8.1.
- `ImmutableCollection::first()` now returns `null` instead of `false` when no item is found.
- `ImmutableCollection::last()` now returns `null` instead of `false` when no item is found.
