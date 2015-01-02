public class Main {
    // All result classes are required to extend this class so that it can be
    // returned by the handle() method in the Handler interface.
    private static abstract class Result {
    }

    private static interface Handler {
        // Handler returns objects of type Result
        public Result handle();
    }

    private static class ListRecipesResult extends Result {
        public final String[] recipes;

        public ListRecipesResult(String recipes[]) {
            this.recipes = recipes;
        }
    }

    private static class ListRecipesHandler implements Handler {
        // The return type here has to be Result even though we know this
        // handler will always return a ListRecipesResult because Result
        // is specified in the Handler interface.
        public Result handle() {
            return new ListRecipesResult(new String[]{"recipe 1", "recipe 2"});
        }
    }

    // Example using the handler
    public static void main(String args[]) {
        ListRecipesHandler handler = new ListRecipesHandler();

        // The result must be explicitly cast to a ListRecipesResult because
        // the signature of the handle() method returns type of Result
        //                          vvvvvvvvvvvvvvvvv
        ListRecipesResult result = (ListRecipesResult) handler.handle();

        // After the cast the recipes property is accessible
        for (String s : result.recipes)
            System.out.print(s + "\n");
    }
}