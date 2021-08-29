<?php

namespace Tests\Feature\Models ;

use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    function it_fetches_trending_articles()
    {
        Article::factory()->count(2)->create();
        Article::factory()->create(['reads'=>10]);
        $mostPopular = Article::factory()->create(['reads'=>20]);
        $articles = Article::trending();
        $this->assertEquals($mostPopular->id,$articles->first()->id);
        $this->assertCount(3,$articles);
    }
}
