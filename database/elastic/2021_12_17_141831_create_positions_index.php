<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreatePositionsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('positions', function (Mapping $mapping, Settings $settings) {
            // to add a new field to the mapping use method name as a field type (in Camel Case),
            // first argument as a field name and optional second argument for additional field parameters
//            $mapping->integer('id');
            $mapping->text('title', ['boost' => 2]);
            $mapping->text("category");
            $mapping->integer("min_age");
            $mapping->integer("max_age");
            $mapping->text("education");
            $mapping->text("gender");
            $mapping->float("salary");
            $mapping->text("location");
            $mapping->date("expired_at");
            $mapping->date("lived_at");
            $mapping->date("created_at");
            $mapping->date("updated_at");
            // you can define a dynamic template as follows
            /*            $mapping->dynamicTemplate('my_template_name', [
                            'match_mapping_type' => 'long',
                            'mapping' => [
                                'type' => 'integer',
                            ],
                        ]);*/

            // you can also change the index settings and the analysis configuration
            $settings->index([
                'number_of_replicas' => 2,
                'refresh_interval' => -1
            ]);

            $settings->analysis([
                'analyzer' => [
                    'title' => [
                        'type' => 'custom',
                        'tokenizer' => 'whitespace'
                    ]
                ]
            ]);
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists("positions");
    }
}
