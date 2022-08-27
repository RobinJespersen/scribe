<?php

namespace Knuckles\Scribe\Extracting\Strategies\Metadata;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;
use Knuckles\Scribe\Attributes\ResponseFromTransformer;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Unauthenticated;
use Knuckles\Scribe\Extracting\DatabaseTransactionHelpers;
use Knuckles\Scribe\Extracting\InstantiatesExampleModels;
use Knuckles\Scribe\Extracting\ParamHelpers;
use Knuckles\Scribe\Extracting\Shared\ApiResourceResponseTools;
use Knuckles\Scribe\Extracting\Shared\TransformerResponseTools;
use Knuckles\Scribe\Extracting\Strategies\PhpAttributeStrategy;

/**
 * @extends PhpAttributeStrategy<Group|Subgroup|Endpoint|Authenticated>
 */
class GetFromMetadataAttributes extends PhpAttributeStrategy
{
    use ParamHelpers;

    protected array $attributeNames = [
        Group::class,
        Subgroup::class,
        Endpoint::class,
        Authenticated::class,
        Unauthenticated::class,
    ];

    protected function extractFromAttributes(
        array $attributesOnMethod, array $attributesOnController,
        ExtractedEndpointData $endpointData
    ): ?array
    {
        $metadata = [
            "groupName" => "",
            "groupDescription" => "",
            "subgroup" => "",
            "subgroupDescription" => "",
            "title" => "",
            "description" => "",
        ];
        foreach ([...$attributesOnController, ...$attributesOnMethod] as $attributeInstance) {
            $metadata = array_merge($metadata, $attributeInstance->toArray());
        }

        return $metadata;
    }

}
