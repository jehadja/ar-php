<?php

namespace Tests\Arabic;

use I18N_Arabic_Normalise;
use Tests\AbstractTestCase;

class NormaliseTest extends AbstractTestCase
{
    
    /**
     * @var I18N_Arabic_Normalise
     */
    protected $normalise;
    
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->normalise = new \I18N_Arabic('Normalise');
    }
    
    /** @test */
    public function it_loads_normalise_class()
    {
        $this->assertInstanceOf(I18N_Arabic_Normalise::class, $this->normalise->myObject);
    }
    
    /** @test */
    public function can_strip_tatweel()
    {
        $text = 'هـذا النــص يتحتــوي علــى تطويــــلات';
        $expected = 'هذا النص يتحتوي على تطويلات';
        $actualText = $this->normalise->stripTatweel($text);
        
        $this->assertEquals($expected, $actualText);
    }
    
    /** @test */
    public function can_strip_tashkeel()
    {
        $text = 'هَذَا النَّصُ يَحْتوي تشكيلاتٍ كُثرٍ';
        $expected = 'هذا النص يحتوي تشكيلات كثر';
        $actualText = $this->normalise->stripTashkeel($text);
        
        $this->assertEquals($expected, $actualText);
    }
    
    /** @test */
    public function can_normalise_hamza()
    {
        $expected = 'اذا انت اكرمت الكريم ملكته وان انت اكرمت اللييم تمردا';
        $actualText = $this->normalise->normaliseHamza('إذا أنت أكرمت الكريم ملكته وإن أنت أكرمت اللئيم تمردا');
        $this->assertEquals($expected, $actualText, 'It should normalise alf-hamze above and down, and YEH_HAMZA');
        
        $expected = 'هولاء';
        $actualText = $this->normalise->normaliseHamza('هؤلآء');
        $this->assertEquals($expected, $actualText, 'It should normalise waw-hamza and Alf-Madda');
        
        $expected = 'تهنِية الاصحاب';
        $actualText = $this->normalise->normaliseHamza('تهنِئة الأصحاب');
        $this->assertEquals($expected, $actualText, 'It should normalise ALEF_HAMZA_ABOVE and Alf-Madda');
    }
    
    /** @test */
    public function it_can_normalise_full_text()
    {
        $text = "مَلأْنَا البَرَّ حَتَّى ضَاقَ عَنَّا وَمَاءَ البَحْرِ نَمْلَؤُهُ سَفِينَا إِذَا بَلَغَ الفِطَامَ لَنَا صَبِيٌّ تَخِرُّ لَهُ الجَبَابِرُ سَاجِدِينَا";
        $expected = 'ملانا البر حتى ضاق عنا وماء البحر نملوه سفينا اذا بلغ الفطام لنا صبي تخر له الجبابر ساجدينا';
        $actualText = $this->normalise->normalise($text);
        $this->assertEquals($expected, $actualText, 'Text should by normalized');
    }
    
    /** @test */
    public function can_unshape_text_by_separating_letters()
    {
        $this->markTestSkipped('Skipped until I figured out how the method should work');
        $actualText = $this->normalise->unshape('هذا النص بحروف متقعطه');
        $expected = 'هذا ال نص ب ح ر وف متقعطه';
        $this->assertEquals($expected, $actualText, 'Text should by unshaped');
    }
    
    /** @test */
    public function it_reverse_utf8_string()
    {
        $actualText = $this->normalise->utf8Strrev('هذا النص معكوس');
        $expectedText = 'سوكعم صنلا اذه';
        
        $this->assertEquals($expectedText, $actualText, 'The actual text should be reversed');
    }
    
    /** @test */
    public function it_can_check_if_passed_character_is_tashkeel()
    {
        $tashkeel = "ً";
        $this->assertTrue((bool)$this->normalise->isTashkeel($tashkeel));
        $this->assertFalse((bool)$this->normalise->isTashkeel('أ'));
    }
    
    /** @test */
    public function it_can_check_if_passed_character_is_harakat()
    {
        $tashkeel = "ً";
        $shadda = 'ّ';
        $this->assertTrue((bool)$this->normalise->isHaraka($tashkeel));
        $this->assertFalse((bool)$this->normalise->isHaraka('أ'));
        $this->assertFalse((bool)$this->normalise->isHaraka($shadda));
    }
    
    /** @test */
    public function it_can_check_if_passed_character_is_short_haraka()
    {
        $fatha = 'َ';
        $tanweenFatha = 'ً';
        $this->assertTrue((bool)$this->normalise->isShortharaka($fatha));
        $this->assertFalse((bool)$this->normalise->isShortharaka($tanweenFatha));
    }
    
    /** @test */
    public function it_can_check_if_passed_character_is_tanween()
    {
        $tanweenFatha = 'ً';
        $fatha = 'َ';
        $this->assertTrue((bool)$this->normalise->isTanwin($tanweenFatha));
        $this->assertFalse((bool)$this->normalise->isTanwin($fatha));
    }
    
    /** @test */
    public function it_can_check_if_passed_character_is_ligature()
    {
        $this->assertTrue((bool)$this->normalise->isLigature(unichr(0xFEF7)));
        $this->assertTrue((bool)$this->normalise->isLigature('ﻷ'));
        $this->assertFalse((bool)$this->normalise->isLigature('ج'));
    }
    
    /** @test */
    public function it_can_check_if_passed_character_is_hamza()
    {
        $this->assertTrue((bool)$this->normalise->isHamza('ء'));
        $this->assertFalse((bool)$this->normalise->isHamza('ج'));
    }
}