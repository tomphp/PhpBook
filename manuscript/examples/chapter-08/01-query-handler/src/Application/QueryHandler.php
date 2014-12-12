<?php

namespace CocktailRater\Application;

use CocktailRater\Application\Exception\NoMatchingHandlerException;
use CocktailRater\Application\Exception\NotAHandlerException;
use CocktailRater\Domain\Repository\RecipeRepository;
use InvalidArgumentException;

class QueryHandler
{
    /** @var RecipeRepository */
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * @throws InvalidArgumentException   If $query is not a query object.
     * @throws NoMatchingHandlerException
     * @throws NotAHandlerException
     */
    public function handle($query)
    {
        $this->assertIsAQuery($query);
        $this->assertQueryHandlerExists($query);

        $handlerName = $this->getHandlerName($query);
        $handler = new $handlerName($this->recipeRepository);

        return $handler->handle($query);
    }

    private function assertIsAQuery($query)
    {
        if ('Query' !== substr(get_class($query), -5, 5)) {
            throw new InvalidArgumentException();
        }
    }

    private function getHandlerName($query)
    {
        return substr(get_class($query), 0, -5) . 'Handler';
    }

    private function assertQueryHandlerExists($query)
    {
        $handlerName = $this->getHandlerName($query);

        if (!class_exists($handlerName)) {
            throw NoMatchingHandlerException::notFound(
                get_class($query),
                $handlerName
            );
        }

        if (!method_exists($handlerName, 'handle')) {
            throw NotAHandlerException::missingHandleMethod($handlerName);
        }
    }
}
