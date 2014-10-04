<?php
/**
 * test case
 */

/**
 * test case.
 */
class WURFL_Configuration_InMemoryConfigTest
    extends PHPUnit_Framework_TestCase
{

    public function testShouldCreateFilePersistence()
    {
        $config = new WURFL_Configuration_InMemoryConfig ();
        $config->wurflFile("wurfl.xml")
            ->wurflPatch("new_web_browsers_patch.xml")
            ->wurflPatch("spv_patch.xml")
            ->allowReload(true)
            ->persistence("file", array("dir" => "./cache"))
            ->cache(
                "file",
                array(WURFL_Configuration_Config::DIR => "./cache", WURFL_Configuration_Config::EXPIRATION => 3600)
            );

        self::assertNotNull($config->persistence);

        self::assertEquals("wurfl.xml", $config->wurflFile);
        self::assertEquals(array("new_web_browsers_patch.xml", "spv_patch.xml"), $config->wurflPatches);

        $persistence = $config->persistence;
        self::assertEquals("file", $persistence ["provider"]);

        self::assertTrue($config->allowReload);
    }

    public function testShouldCreateConfiguration()
    {
        $config = new WURFL_Configuration_InMemoryConfig ();
        $params = array("host" => "127.0.0.1");
        $config->wurflFile("wurfl.xml")
            ->wurflPatch("new_web_browsers_patch.xml")
            ->wurflPatch("spv_patch.xml")
            ->persistence("memcache", $params)
            ->cache(
                "file",
                array(WURFL_Configuration_Config::DIR => "./cache", WURFL_Configuration_Config::EXPIRATION => 3600)
            );

        self::assertNotNull($config->persistence);

        self::assertEquals("wurfl.xml", $config->wurflFile);
        self::assertEquals(array("new_web_browsers_patch.xml", "spv_patch.xml"), $config->wurflPatches);

        $persistence = $config->persistence;
        self::assertEquals("memcache", $persistence ["provider"]);
        self::assertEquals(array("host" => "127.0.0.1"), $persistence ["params"]);

        $cache = $config->cache;
        self::assertEquals("file", $cache ["provider"]);
        self::assertEquals(
            array(WURFL_Configuration_Config::DIR => "./cache", WURFL_Configuration_Config::EXPIRATION => 3600),
            $cache ["params"]
        );
    }

    public function testShouldCreateConfigurationWithAPCPersistenceProviderAndAPCCacheProvider()
    {
        $config = new WURFL_Configuration_InMemoryConfig ();
        $params = array("host" => "127.0.0.1");
        $config->wurflFile("wurfl.xml")
            ->wurflPatch("new_web_browsers_patch.xml")
            ->wurflPatch("spv_patch.xml")
            ->persistence(WURFL_Storage_Apc::EXTENSION_MODULE_NAME, $params)
            ->cache(WURFL_Storage_Apc::EXTENSION_MODULE_NAME, $params);

        self::assertNotNull($config->persistence);

        self::assertEquals("wurfl.xml", $config->wurflFile);
        self::assertEquals(array("new_web_browsers_patch.xml", "spv_patch.xml"), $config->wurflPatches);

        $persistence = $config->persistence;
        self::assertEquals("apc", $persistence ["provider"]);
        self::assertEquals($params, $persistence ["params"]);

        $cache = $config->cache;
        self::assertEquals("apc", $cache ["provider"]);
        self::assertEquals($params, $cache ["params"]);
    }

    public function testShouldCreateConfigurationForMultipleMemcacheBackend()
    {
        $config = new WURFL_Configuration_InMemoryConfig ();
        $params = array(
            "host" => "10.211.55.10;10.211.55.2",
            "port" => "11211",
            "namespace" => "wurfl"
        );
        $config->wurflFile("wurfl.xml")
            ->wurflPatch("new_web_browsers_patch.xml")
            ->wurflPatch("spv_patch.xml")
            ->persistence("memcache", $params);
    }
}

