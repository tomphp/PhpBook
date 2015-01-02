<?php

namespace CocktailRater\Application;

use CocktailRater\Application\Exception\NoMatchingHandlerException;
use CocktailRater\Application\Exception\NotAHandlerException;
use CocktailRater\Application\Handler;
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
     *
     * @return mixed
     */
    public function handle($query)
    {
        $this->assertIsAQuery($query);
        $this->assertQueryHandlerExists($query);

        $handlerName = $this->getHandlerName($query);

        // leanpub-start-insert
        $handler = new $handlerName($query, $this->recipeRepository);

        return $handler->handle();
        // leanpub-end-insert
    }

    private function assertIsAQuery($query)
    {
        if ('Query' !== substr(get_class($query), -5, 5)) {
            throw new InvalidArgumentException();
        }
    }

    /** @return string */
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

        if (!is_subclass_of($handlerName, Handler::class)) {
            throw NotAHandlerException::missingHandleMethod($handlerName);
        }
    }
}
