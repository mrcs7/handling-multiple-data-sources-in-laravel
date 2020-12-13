<?php


namespace Tests\Feature;



use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_add_products_successfully_using_correct_json()
    {
        $response = $this->postJson('/api/v1/products/import', [
            $this->generateJson()
        ], [
            'Content-Type' => 'application/json'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'iPhone 11 Pro']);
    }

    /** @test  */
    public function it_should_return_validation_error_if_json_structure_is_wrong()
    {
        $jsonBody = $this->generateJson();
        unset($jsonBody['name']);
        $response = $this->postJson('/api/v1/products/import', [
            $jsonBody
        ], [
            'Content-Type' => 'application/json'
        ]);
        $response->assertStatus(422);
    }

    public function generateJson()
    {
        return [
            "name" => "iPhone 11 Pro",
            "identifier" => "ISLAMHAMDY001X",
            "description" => "Sofa Samt ca. B191xT78xH78cm, hellgrau",
            "categories" => [
                "Mobile"
            ],
            "prices" => [
                [
                    "validFrom" => "2020-12-01T00:00:00.000000Z",
                    "price" => 10,
                    "validTo" => "2020-11-30T23:59:59.999999Z"
                ],
                [
                    "price" => 10.97,
                    "validFrom" => "2020-12-01T00:00:00.000000Z",
                    "validTo" => "2020-12-31T23:59:59.999999Z"
                ],
                [
                    "validFrom" => "2021-01-01T00:00:00.000000Z",
                    "price" => 9.93,
                    "validTo" => "2021-01-31T23:59:59.999999Z"
                ],
                [
                    "price" => 9.94,
                    "validFrom" => "2021-02-01T00:00:00.000000Z",
                    "validTo" => "2021-02-28T23:59:59.999999Z"
                ]
            ],
            "images" => [
                "https=>\/\/depot.dam.aboutyou.cloud\/images\/5fb50f3f8c2be.jpg?width=1200&height=1200",
                "https=>\/\/depot.dam.aboutyou.cloud\/images\/5fb50f3f8c2ef.jpg?width=1200&height=1200",
                "https=>\/\/depot.dam.aboutyou.cloud\/images\/5fb50f3f8c308.jpg?width=1200&height=1200",
                "https=>\/\/depot.dam.aboutyou.cloud\/images\/5fb50f3f8c329.jpg?width=1200&height=1200"
            ]

        ];
    }

}
