# iMoneza PHP API Documentation

## Data Objects

The second parameter of the `Connection::request()` method requires a data object object of the interface `iMoneza\Data\DataInterface` in order
to hold the resultant data.

There are a number of getters and setters that can be used to store the data set with this object.  You can expect that the connection request method
will populate the data object for you.  You can, however, overwrite any of that data by accessing the setters yourself.

The names of the objects reflect the name of the data they will contain.  Some data objects are used directly in the `request` 
method.  Others are populated internally when the parent object needs a child object or collection of objects.  Date and time 
information is represented with the PHP `DateTime` object.

Let's look through them.

### Data Object Definitions

#### `iMoneza\Data\PricingGroup`

This represents the pricing group of a resource.

- `setPricingGroupID()`/`getPricingGroupID()`  The pricing group ID.

- `setName()`/`getName()`  The name of the pricing group.

- `setIsDefault()`/`isDefault()`  Whether this is the default pricing group.

- `setPricingModel()`/`getPricingModel()`  

- `setPrice()`/`getPrice()`  The price.

- `setExpirationPeriodUnit()`/`getExpirationPeriodUnit()`  

- `setTargetConversionRate()`/`getTargetConversionRate()`  

- `setTargetConversionPriceFloor()`/`getTargetConversionPriceFloor()`  

- `setTargetConversionHitsPerRecalculationPeriod()`/`getTargetConversionHitsPerRecalculationPeriod()`  

#### `iMoneza\Data\Property`

This represents your property.

- `setName()`/`getName()`  The name of the property.

- `setTitle()`/`getTitle()`  The title of the property.

- `setDynamicallyCreateResources()`/`isDynamicallyCreateResources()`  Whether to dynamically create resources.

- `setEnableQuota()`/`isEnableQuota()`  Whether a quota or meter is activated.

- `setEnableSubscriptions()`/`isEnableSubscriptions()`  Whether subscriptions are enabled.

- `setEnableSinglePurchases()`/`isEnableSinglePurchases()`  Whether ala-cart single purchases are enabled.

- `setFreeResourcesRequireAuthentication()`/`isFreeResourcesRequireAuthentication()`  Whether free resources require authentication.

- `setQuota()`/`getQuota()`  The quota value.

- `setQuotaPeriod()`/`getQuotaPeriod()`  The quota period value.

- `setSubscriptionGroups()`/`getSubscriptionGroups()`  An array of subscription group objects.

- `setPricingGroups()`/`getPricingGroups()`  An array of pricing group objects

- `setAlwaysRequireAuthentication()`/`isAlwaysRequireAuthentication()`  Whether to always require authentication





#### `iMoneza\Data\None`

This is a special data object that is used for methods that return no data - or if you want to ignore any data that was retrieved.

