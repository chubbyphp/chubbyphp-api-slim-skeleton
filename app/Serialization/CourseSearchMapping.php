<?php

declare(strict_types=1);

namespace Chubbyphp\ApiSkeleton\Serialization;

use Chubbyphp\Serialization\Accessor\PropertyAccessor;
use Chubbyphp\Serialization\Link\LinkGeneratorInterface;
use Chubbyphp\Serialization\Link\NullLink;
use Chubbyphp\Serialization\Mapping\FieldMapping;
use Chubbyphp\Serialization\Mapping\FieldMappingInterface;
use Chubbyphp\Serialization\Mapping\LinkMapping;
use Chubbyphp\Serialization\Mapping\LinkMappingInterface;
use Chubbyphp\Serialization\Mapping\ObjectMappingInterface;
use Chubbyphp\Serialization\Serializer\Field\CollectionFieldSerializer;
use Chubbyphp\Serialization\Serializer\Field\ValueFieldSerializer;
use Chubbyphp\Serialization\Serializer\Link\CallbackLinkSerializer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Chubbyphp\ApiSkeleton\Search\CourseSearch;

final class CourseSearchMapping implements ObjectMappingInterface
{
    /**
     * @var LinkGeneratorInterface
     */
    private $linkGenerator;

    /**
     * @param LinkGeneratorInterface $linkGenerator
     */
    public function __construct(LinkGeneratorInterface $linkGenerator)
    {
        $this->linkGenerator = $linkGenerator;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return CourseSearch::class;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'course-search';
    }

    /**
     * @return FieldMappingInterface[]
     */
    public function getFieldMappings(): array
    {
        return [
            new FieldMapping('page', new ValueFieldSerializer(
                new PropertyAccessor('page'),
                ValueFieldSerializer::CAST_INT)
            ),
            new FieldMapping('perPage', new ValueFieldSerializer(
                new PropertyAccessor('perPage'),
                ValueFieldSerializer::CAST_INT)
            ),
            new FieldMapping('sort'),
            new FieldMapping('order'),
            new FieldMapping('count'),
            new FieldMapping('pages'),
        ];
    }

    /**
     * @return FieldMappingInterface[]
     */
    public function getEmbeddedFieldMappings(): array
    {
        return [
            new FieldMapping('courses', new CollectionFieldSerializer(new PropertyAccessor('courses'))),
        ];
    }

    /**
     * @return LinkMappingInterface[]
     */
    public function getLinkMappings(): array
    {
        return [
            new LinkMapping('self', new CallbackLinkSerializer(
                function (Request $request, CourseSearch $courseSearch, array $fields) {
                    unset($fields['count'], $fields['pages']);

                    return $this->linkGenerator->generateLink($request, 'course_search', [], $fields);
                }
            )),
            new LinkMapping('prev', new CallbackLinkSerializer(
                function (Request $request, CourseSearch $courseSearch, array $fields) {
                    if ($courseSearch->getPage() > 1) {
                        $fields['page'] -= 1;

                        unset($fields['count'], $fields['pages']);

                        return $this->linkGenerator->generateLink($request, 'course_search', [], $fields);
                    }

                    return new NullLink();
                }
            )),
            new LinkMapping('next', new CallbackLinkSerializer(
                function (Request $request, CourseSearch $courseSearch, array $fields) {
                    if ($fields['page'] < $courseSearch->getPages()) {
                        $fields['page'] += 1;

                        unset($fields['count'], $fields['pages']);

                        return $this->linkGenerator->generateLink($request, 'course_search', [], $fields);
                    }

                    return new NullLink();
                }
            )),
            new LinkMapping('create', new CallbackLinkSerializer(
                function (Request $request, CourseSearch $courseSearch, array $fields) {
                    return $this->linkGenerator->generateLink($request, 'course_create');
                }
            )),
        ];
    }
}
