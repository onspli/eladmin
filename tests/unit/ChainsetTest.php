<?php
use PHPUnit\Framework\TestCase;
use Onspli\Eladmin\Chainset\Chainset;

final class ChainsetTest extends TestCase
{


  public function testAddAndDeleteChild(): void
  {
    $cs = new Chainset;
    $this->assertFalse(isset($cs->child));
    // create child
    $cs->child;
    $this->assertInstanceOf(Chainset::class, $cs->child);
    $this->assertTrue(isset($cs->child));
    // delete child
    unset($cs->child);
    $this->assertFalse(isset($cs->child));
  }

    public function testSetPropertiesToChild(): void
    {
      $cs = new Chainset;
      $cs->child->prop1('val1')->prop2('val2');
      $cs->child->prop3('val3');

      $this->assertEquals('val1', $cs->child->prop1);
      $this->assertEquals('val2', $cs->child->prop2);
      $this->assertEquals('val3', $cs->child->prop3);
    }

    public function testSetPropertiesToParent(): void
    {
      $this->expectException(\Exception::class);
      $cs = new Chainset;
      $cs->prop1('val');
    }

    public function testOrder() : void
    {
      $cs = new Chainset;
      $cs->word1->val('Hello');
      $cs->word3->val('world');
      $cs->word2->val('!');
      $res = "";
      foreach($cs as $word) $res .= $word->val." ";
      $this->assertEquals("Hello world ! ", $res);
    }

    public function testBefore() : void
    {
      $cs = new Chainset;
      $cs->word1->val('Hello');
      $cs->word2->val('!');
      $cs->word3->val('world')->before('word2');
      $res = "";
      foreach($cs as $word) $res .= $word->val." ";
      $this->assertEquals("Hello world ! ", $res);
    }

    public function testBeforeNull() : void
    {
      $cs = new Chainset;
      $cs->word1->val('Hello');
      $cs->word2->val('!');
      $cs->word3->val('world');
      $cs->word2->before(null);
      $res = "";
      foreach($cs as $word) $res .= $word->val." ";
      $this->assertEquals("Hello world ! ", $res);
    }

    public function testAfter() : void
    {
      $cs = new Chainset;
      $cs->word1->val('Hello');
      $cs->word2->val('!');
      $cs->word3->val('world');
      $cs->word2->after('word3');
      $res = "";
      foreach($cs as $word) $res .= $word->val." ";
      $this->assertEquals("Hello world ! ", $res);
    }

    public function testAfterNull() : void
    {
      $cs = new Chainset;
      $cs->word3->val('world');
      $cs->word1->val('Hello');
      $cs->word2->val('!');
      $cs->word1->after(null);
      $res = "";
      foreach($cs as $word) $res .= $word->val." ";
      $this->assertEquals("Hello world ! ", $res);
    }

    private function performanceStep(): void
    {
      $cs = new Chainset;
      $cs->word1->val('Hello');
      $cs->word2->val('!');
      $cs->word3->val('world')->before('word2');
      $cs->word4->val('!')->before('word1');
      $cs->word5->val('!')->before('word1');
      $cs->word6->val('!')->before('word1');
      $cs->word7->val('!')->before('word1');
      $cs->word8->val('!')->before('word1');
      $cs->word9->val('!')->before('word1');
      $cs->word10->val('!')->before('word1');
      $cs->word11->val('!')->before('word1');
      $cs->word12->val('!')->before('word1');
    }

    public function testPerformance() : void
    {
      $time0 = microtime(true);
      for($i=0; $i<100000; $i++)
        $this->performanceStep();
      $duration = microtime(true) - $time0;
      $this->assertLessThan(3, $duration);

    }
}
