<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Filter\Test\Unit;

/**
 * Translit url test.
 */
class TranslitUrlTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\Filter\TranslitUrl
     */
    protected $model;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->model = $objectManager->getObject(\Magento\Framework\Filter\TranslitUrl::class);
    }

    /**
     * @param string $testString
     * @param string $result
     * @param string $resultIconv
     * @param bool $isIconv
     * @dataProvider filterDataProvider
     */
    public function testFilter($testString, $result, $resultIconv, $isIconv)
    {
        if ($isIconv) {
            $this->assertEquals($resultIconv, $this->model->filter($testString));
        } else {
            $this->assertEquals($result, $this->model->filter($testString));
        }
    }

    /**
     * @return array
     */
    public function filterDataProvider()
    {
        $isIconv = '"libiconv"' == ICONV_IMPL;
        return [
            ['test', 'test', 'test', $isIconv],
            ['привет мир', 'privet-mir', 'privet-mir', $isIconv],
            [
                'Weiß, Goldmann, Göbel, Weiss, Göthe, Goethe und Götz',
                'weiss-goldmann-goebel-weiss-goethe-goethe-und-goetz',
                'weiss-goldmann-goebel-weiss-goethe-goethe-und-goetz',
                $isIconv
            ],
            [
                '❤ ☀ ☆ ☂ ☻ ♞ ☯ ☭ ☢ € → ☎ ❄ ♫ ✂ ▷ ✇ ♎ ⇧ ☮',
                '',
                'eur',
                $isIconv
            ],
            ['™', 'tm', 'tm', $isIconv]
        ];
    }
}
