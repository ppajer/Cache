# Cache
A simple filesystem based cache in PHP. Ideal for caching large API responses that rarely need updating.

## Installation

Install as a Composer package or download this repository and include the class in your project.

## Usage

To have your data automatically cached, create a new Cache instance by specifying a file path and an expiry time in seconds. If the file doesn't exist, it will be created.

```(php)

$path = 'cache.json';
$expiry = 36000;
$cache = new Cache($path, $expiry);

if ($cache->isExpired()) {
  $data = // get some new data;
  $cache->write($data);
 } else {
  $data = $cache->read();
 }
 ```
 
 ## Declarative updates
 
 The above method lets you control when and if your cache is updated, but if you don't require that level of control you can simply pass a function that returns the updated data for the cache in case it is expired, and let it handle the rest. This is useful if your data is not likely to change dynamically and you just need up-to-date caches to read from.
 
 ```(php)
 
 function get_data() {
  // do something here
  return $data;
 }
 
 class API {
  public static function get_data() {
    // some api stuff
    return $data;
   }
 }
 
 $cache = new Cache('cache.json', 36000, 'get_data'); // Cache will update itself using the provided function if expired
 $apiCache = new Cache('api.json', 36000, array(API::class, 'get_data')); // Accepts any callable that returns data
 ```
