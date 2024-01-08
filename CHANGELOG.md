Change Log
=====

# 0.2.1
- BC BREAK - Require item class name to be provided via abstract method `getItemClassName()` instead of via the collection constructor.
- BC BREAK - Removed support for `ArrayAccess`, and replicate functionality via more meaningful methods such as `Collection::has()` and `Collection::get()`.
- BC BREAK - `Collection::toArray()` renamed to `Collection::all()`.
- Added the factory methods `Collection::from()` and `Collection::empty()`.
- Added helper methods `Collection::isEmpty()` and `Collection::isNotEmpty()`.
- Added helper method `Collection::mapTo()` to map to a new Collection of a different type.
- Added `Collection::reverse()` helper to reverse the order of the collection.
- Support creating collections from Doctrine Collections using `Collection::fromDoctrine()`.
- Support creating collections by mapping array of other objects using `Collection::mapFrom()`.

# 0.2.0
- Minimum PHP version bumped to 8.1.
- `ImmutableCollection::first()` now returns `null` instead of `false` when no item is found.
- `ImmutableCollection::last()` now returns `null` instead of `false` when no item is found.
