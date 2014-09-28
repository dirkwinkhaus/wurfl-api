<?php

require_once dirname(__FILE__) . '/FileTest.php';

class WURFL_Storage_FileSecondaryCacheTest
    extends WURFL_Storage_FileTest
{

    public function testMemcache()
    {
        $this->checkMemcacheDeps();
        $cache = new WURFL_Storage_Memcache(
            array(
                'host' => '127.0.0.1',
            )
        );
        self::assertCacheAllowed($cache);
    }

    public function testApc()
    {
        $this->checkApcDeps();
        $cache = new WURFL_Storage_Apc(array());
        self::assertCacheAllowed($cache);
    }

    private function assertCacheAllowed(WURFL_Storage_Base $cache)
    {

        $config = array(
            "dir"                                  => self::storageDir(),
            WURFL_Configuration_Config::EXPIRATION => 0,
        );

        $storage          = new WURFL_Storage_File($config);
        $uncached_storage = new WURFL_Storage_File($config);

        self::assertTrue($storage->supportsSecondaryCaching());
        self::assertTrue($storage->validSecondaryCache($cache));

        $storage->setCacheStorage($cache);

        $storage->save("foo", "foo");

        sleep(1);

        // Make sure it's there
        self::assertEquals("foo", $storage->load("foo"));
        $cache->clear();
        // Check after cache is empty (fall through to file)
        self::assertEquals("foo", $storage->load("foo"));
        // Remove underlying files
        $uncached_storage->clear();
        // Check cache without file-backing
        self::assertEquals("foo", $storage->load("foo"));
        // Clear cache
        $cache->clear();
        self::assertNull($storage->load("foo"));
    }

    private function checkMemcacheDeps()
    {
        if (!extension_loaded('memcache')) {
            $this->markTestSkipped(
                "PHP extension 'memcache' must be loaded and a local memcache server running to run this test."
            );
        }
    }

    private function checkApcDeps()
    {
        if (!extension_loaded('apc') || @apc_cache_info() === false) {
            $this->markTestSkipped(
                "PHP extension 'apc' must be loaded and enabled for CLI to run this test (http://www.php.net/manual/en/apc.configuration.php#ini.apc.enable-cli)."
            );
        }
    }
}