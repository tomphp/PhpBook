<?php

namespace CocktailRater\Application;

use CocktailRater\Application\Exception\NoMatchingHandlerException;
use CocktailRater\Application\Exception\NotAHandlerException;
// leanpub-start-insert
use CocktailRater\Application\Handler;
use CocktailRater\Application\Query;
use CocktailRater\Application\Result;
// leanpub-end-insert
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

    // leanpub-start-insert
    /**
     * @throws InvalidArgumentException   If $query is not a query object.
     * @throws NoMatchingHandlerException
     * @throws NotAHandlerException
     *
     * @return Result
     */
    // leanpub-end-insert
    public function handle(Query $query)
    {
        // leanpub-start-insert
        $this->assertQueryIsNamedCorrectly($query);
        // leanpub-end-insert
        $this->assertQueryHandlerExists($query);

        $handlerName = $this->getHandlerName($query);
        $handler = new $handlerName($this->recipeRepository);

        return $handler->handle($query);
    }

    // leanpub-start-insert
    private function assertQueryIsNamedCorrectly(Query $query)
    // leanpub-end-insert
    {
        if ('Query' !== substr(get_class($query), -5, 5)) {
            throw new InvalidArgumentException();
        }
    }

    // leanpub-start-insert
    private function getHandlerName(Query $query)
    // leanpub-end-insert
    {
        return substr(get_class($query), 0, -5) . 'Handler';
    }

    // leanpub-start-insert
    private function assertQueryHandlerExists(Query $query)
    // leanpub-end-insert
    {
        $handlerName = $this->getHandlerName($query);

        if (!class_exists($handlerName)) {
            throw NoMatchingHandlerException::notFound(
                get_class($query),
                $handlerName
            );
        }

        // leanpub-start-insert
        if (!is_subclass_of($handlerName, Handler::class)) {
            throw NotAHandlerException::missingHandleMethod($handlerName);
        }
        // leanpub-end-insert
    }
}
