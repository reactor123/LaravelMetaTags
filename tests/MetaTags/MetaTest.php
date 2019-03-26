<?php

namespace Butschster\Tests\MetaTags;

use Butschster\Head\MetaTags\Meta;
use PHPUnit\Framework\TestCase;

class MetaTest extends TestCase
{
    function test_it_can_be_reset()
    {
        $meta = (new Meta())
            ->setTitle('test title')
            ->prependTitle('additional title')
            ->setDescription('meta description')
            ->setKeywords(['keyword 1', 'keyword 2'])
            ->setRobots('no follow')
            ->setNextHref('http://site.com')
            ->setPrevHref('http://site.com')
            ->setContentType('<h5>text/html</h5>')
            ->setHrefLang('en', 'http://site.com/en')
            ->setHrefLang('ru', 'http://site.com/ru')
            ->setViewport('width=device-width, initial-scale=1')
            ->addMeta('og::title', [
                'content' => 'test og title'
            ]);

        $meta->reset();

        $this->assertNull($meta->getPrevHref());
        $this->assertNull($meta->getNextHref());
        $this->assertNull($meta->getDescription());
        $this->assertNull($meta->getKeywords());
        $this->assertNull($meta->getRobots());
        $this->assertNull($meta->getCanonical());
        $this->assertNull($meta->getContentType());
        $this->assertNull($meta->getViewport());
        $this->assertNull($meta->getHrefLang('en'));
        $this->assertNull($meta->getHrefLang('ru'));
        $this->assertNull($meta->getMeta('og::title'));
    }

//    function test_seo_meta_tags_can_be_read_from_seo_meta_tags_interface()
//    {
//        $meta = new Meta();
//
//        $metatags = m::mock(SeoMetaTagsInterface::class);
//
//        $meta->setSeoMetaTags($metatags);
//
//        $html = $meta->toHtml();
//
//        $this->assertStringContainsString('<title>additional title | test title</title>', $html);
//        $this->assertStringContainsString('<meta name="description" content="meta description">', $html);
//        $this->assertStringContainsString('<meta name="keywords" content="keyword 1, keyword 2">', $html);
//    }

    function test_meta_information_can_be_rendered()
    {
        $meta = (new Meta())
            ->setTitle('test title')
            ->prependTitle('additional title')
            ->setDescription('meta description')
            ->setKeywords(['keyword 1', 'keyword 2'])
            ->setRobots('no follow')
            ->setNextHref('http://site.com')
            ->setPrevHref('http://site.com')
            ->setCanonical('http://site.com')
            ->setHrefLang('en', 'http://site.com/en')
            ->setHrefLang('ru', 'http://site.com/ru')
            ->setContentType('<h5>text/html</h5>')
            ->setViewport('width=device-width, initial-scale=1')
            ->addMeta('og::title', [
                'content' => 'test og title'
            ]);

        $html = $meta->toHtml();

        $this->assertStringContainsString('<meta name="viewport" content="width=device-width, initial-scale=1">', $html);
        $this->assertStringContainsString('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">', $html);
        $this->assertStringContainsString('<title>additional title | test title</title>', $html);
        $this->assertStringContainsString('<meta name="description" content="meta description">', $html);
        $this->assertStringContainsString('<meta name="keywords" content="keyword 1, keyword 2">', $html);
        $this->assertStringContainsString('<meta name="robots" content="no follow">', $html);
        $this->assertStringContainsString('<meta name="og::title" content="test og title">', $html);
        $this->assertStringContainsString('<link rel="next" href="http://site.com" />', $html);
        $this->assertStringContainsString('<link rel="prev" href="http://site.com" />', $html);
        $this->assertStringContainsString('<link rel="canonical" href="http://site.com" />', $html);
        $this->assertStringContainsString('<link rel="alternate" hreflang="en" href="http://site.com/en" />', $html);
        $this->assertStringContainsString('<link rel="alternate" hreflang="ru" href="http://site.com/ru" />', $html);
    }

}