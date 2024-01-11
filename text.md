# Introduction
    php  -S localhost:8888

# secttion
    navigation  area
    header  area
    main content  area

# Page Links
    <a href="/" class="text-gray-300 hover:bg-gray-700 px-3 py-2 text-sm font-medium" aria-current="page">Home</a>
    <a href="/about.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">About</a>
    <a href="/contact.php" class="bg-gray-900 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Contact</a>
    
    THIS ISNT THHE BETTER WAY

# PHP PARTIALS
    - Build a delicated folder / Directory for our Views
            - index.view.php
            - about.view.php
            - contact.view.php
    -  We dont want to duplicate the file , create partial directory within views
            Partials
                nav.php
    - Cut thee doctype to head section 
            head.php
            footer.php
    - Extract the banner/header
    - Make a portion of our partial dynamic
        Let think these files as controllers
            about.php
            index.php
            contact.php
        Accepting the incomminng request, providing response
            AAny variable we provvided within the controller will accessed in partials views
            $heading = "Contact";
        - Open Header.php
            <?= $heading ?>

#  SUPERGLOBALS AND CURRENT PAGE  STYLING
    can be accesssed to any files
    https://www.w3schools.com/php/php_superglobals.asp
        - Open the Navigation partials .
                views/partials/nav.php

        echo  "<pre>";
            var_dump($_SERVER);
        echo  "</pre>";
        
        die();

            function  dd($value)
                {
                echo  "<pre>";
                var_dump($value);
                echo  "</pre>";
                
                    die();
                }
                
                dd($_SERVER);
    REQUEST_URI -  Show the  current page is .

            function  dd($value)
                {
                echo  "<pre>";
                var_dump($value);
                echo  "</pre>";
                
                    die();
                }
                
                echo $_SERVER['REQUEST_URI'];

    Current Page
        <a href="/" class="<?php if ($_SERVER['REQUEST_URI'] === '/') { echo  'bg-gray-900 text-white';} else { echo 'text-gray-300';} ?> hover:bg-gray-700 rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Home</a>
    The above is mess

            if ($_SERVER['REQUEST_URI'] === '/') {
                echo  'bg-gray-900 text-white';
            } else {
            echo 'text-gray-300';
            }

    itenary Operator   (ask a quuestion   truth  'do this' if not truth "do this"
            echo $_SERVER['REQUEST_URI'] === '/' ? 'bg-gray-900 text-white' : 'text-gray-300';
        class="<?= $_SERVER['REQUEST_URI'] === '/' ? 'bg-gray-900 text-white' : 'text-gray-300'?>
    Even the itenary operatoor we can makee even cleaner
        creae a file called function.php
        call the function to each  file

# MAKE A PHP ROUTER
        https://beamtic.com/creating-a-router-in-php
    - Buildinng a custom router froom scratch
    - Create a folder fo called controller
            about.php
            contact.php
            index.php
    - Create a single point of entry, handling current route
                require  'functions.php';
        
        $uri = $_SERVER['REQUEST_URI'];
        
        if ($uri === '/'){
        require 'controllers/index.php';
        
        }else if ($uri === '/about'){
        require 'controllers/about.php';
        
        }else if ($uri === '/contact'){
        require 'controllers/contact.php';
        }
    Queery String
        http://localhost:8888/contact?nname=ben
    -php a function called parse_url()

                array(2) {
                ["path"]=>
                string(8) "/contact"
                ["query"]=>
                string(9) "nname=ben"
                }
    - refactor  code
    -  crreate a delicated file for router.php

# CREATE AA MYSQL DATABASE
    zsh: command not found: mysql-uroot

    - To create a database  and table

# PDOI FIRST STEPS
    - End result is quuery this table to reach into php
    - function wwithin the class iss called method
                $dsn = "mysql:host=localhost;port=3306;dbname=website-application;user=root;charset=utf8mb4";

                $pdo =new PDO($dsn, 'root');
                
                $statement = $pdo->prepare("select * from posts");
                
                $statement->execute();
                
                $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                //dd($posts);
                foreach ($posts as $post){
                echo "<li>" . $post['title'] ."</li>";
                }
    - 

# EXTRACT A PHP DATABASES CLASS

    $dsn = "mysql:host=localhost;port=3306;dbname=website-application;user=root;charset=utf8mb4";

    $pdo =new PDO($dsn, 'root');
    
    $statement = $pdo->prepare("select * from posts");
    
    $statement->execute();
    
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    //dd($posts);
    foreach ($posts as $post){
    echo "<li>" . $post['title'] ."</li>";
    }
    
    Convert into class
        class Database
        {
        public $connection; //instance property
        public  function  __construct()
        {
        $dsn = "mysql:host=localhost;port=3306;dbname=website-application;user=root;charset=utf8mb4";
        
                $this->connection = new PDO($dsn);
                //$pdo =new PDO($dsn, 'root');
            }
            public  function query($query)
            {
        
                //$statement = $pdo->prepare($query); //"select * from posts"
                $statement = $this->connection->prepare($query); //"select * from posts"
                $statement->execute();
        
                return  $statement;
            }
        }
        
        $db = new Database();
        $post = $db->query("select * from posts where id = 1")->fetch(PDO::FETCH_ASSOC);
        dd($post['title']);

# ENVIRONMENT AND CONFIGURATION FLEXIBILITY
    - we need to work on dabatabbse class to be flexible.
         $dsn = "mysql:host=localhost;port=3306;dbname=website-application;user=root;charset=utf8mb4";
    - scope resolution operation  $dsn = "mysql:host=localhost;port=3306;dbname=website-application;user=root;charset=utf8mb4";

                $dsn = "mysql:host=localhost;port=3306;dbname=website-application;user=root;charset=utf8mb4";
                $dsn = "mysql:host=localhost;port=3306;dbname=website-application;charset=utf8mb4";

    - dd(http_build_query($config, '', ';'));
        Example string(58) "host=;port=3306;dbname=website-application;charset=charset"
        dd('mysql:' . http_build_query($config, '', ';'));
        dd('mysql:' . http_build_query($config, '', ';'));
    - $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
        Is equivalent to  beloww is the simpler way
                $dsn = 'mysql:' . http_build_query($config, '', ';');
    - Take the config and pussh outof the class ,as data is dyanmic and paaste  into index.php and  pass to our constructor
            $config = [
            'host' => '',
            'port' => 3306,
            'dbname' => 'website-application',
            'charset' => 'utf8mb4',
        ];
    - To  extractt the connfi for local and production 
            <?php

                return [
                'host' => '',
                'port' => 3306,
                'dbname' => 'website-application',
                'charset' => 'utf8mb4',
                ];
    - To way to solve this problem ass part of dsn
                $this->connection = new PDO($dsn, 'root', '', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    - Pass in  the constructor username and password
            public  function  __construct($config ,  $username, $password) {}
    
              $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);  
    - assign the default value 
         public  function  __construct($config ,  $username='root', $password='') {}
    - The  config file can be used to all application , we need to key 
                return [
                'host' => '',
                'port' => 3306,
                'dbname' => 'website-application',
                'charset' => 'utf8mb4',
            ];  TO

            return [
    'database'=> [
        'host' => '',
        'port' => 3306,
        'dbname' => 'website-application',
        'charset' => 'utf8mb4',
        ],
    
        'services'=>[
            'prerender' =>[
                'token' => '',
                'secret' => ''
            ]
        ]
    ];

    NNB: Takinng the dynnamic data annd push upward, 
         Environemt  local vs production
         Lern about  return and taking data into a file  config.php


# SQL INJECTION VULNERABIILITY EXPLAINED
    - sql ijection and formatting and danger associate
        PROGRAMMING - USER IS GUILTY  NOT INNOCENT
    - Access the query string - $_GET
        $id = $_GET['id'];

        $post = $db->query("select * from posts where id = 1")->fetch();
        $post = $db->query("select * from posts where id = {$id}")->fetch();
        ex
            http://localhost:8888/?id=1
    - TThis is baad as we're taking the vunerabiility
        $post = $db->query("select * from posts where id = {$id}")->fetch();

    solution
        $id = $_GET['id'];

        $query = "select * from posts where id = {$id}";
        
        dd($query);
        
        $post = $db->query()->fetch($query);


            example string(32) "select * from posts where id = 1"

    - Avoid
        $id = $_GET['id']; //query string
        $query = "select * from posts where id = {$id}";
    send tthrou the query and bind
        Database.php
         public  function query($query, $params = [])
            {
        
                //$statement = $pdo->prepare($query); //"select * from posts"
                $statement = $this->connection->prepare($query); //"select * from posts"
        
                $statement->execute($params);
        
                return  $statement;
            }
        index.php
        $post = $db->query($query, [$id])->fetch();

            http://localhost:8888/?id=1;drop%20table.%20users

    NEVER NEVER ACCEPT INLINE THE  USER DATA  IN  QUERY STRING
    1: QUUESTION MAARK  ?
            $id = $_GET['id']; //query string
            $query = "select * from posts where id = ?";
            
            //dd($query);
            
            $post = $db->query($query, [$id])->fetch();

    2: KEY  : 
            $id = $_GET['id']; //query string
            $query = "select * from posts where id = :id";
            
            //dd($query);
            
            $post = $db->query($query, ['id' => $id])->fetch();

# DATABASES TABLES AND INDEXES
    notes belongs to particular user
    one user can have a particular one email address
    Set the INDEX and Foreign key

# RENDER THE NOTES  AND NOTE PAGE
    . registering  routes
        router.php
    . Controllers can gather all the data  and pass to  the view
        controllers/notes.php
    .View is responsible for presentting  that to  the user
        views/notes.view.php
    . Fetch  all notes = Controllers

# INTRODUCTION TO AUTHORIZATION
    Authorization , status  code and magic number
    eg Noted of id 6 was created by  user id 3
        http://localhost:8888/notes?iid=2
    The notes  ypu  created shoudn't accessible to anyone .access to browser
            STEPS
                update the sql query
    controllers/note.php
            $note = $db->query('select * from notes where id = :id', ['id' => $_GET['id']] )->fetch();
    
    $note = $db->query('select * from notes where user_id = :user and id = :id', [
    'user' => 1,
    'id' => $_GET['id']]
        )->fetch();
        
        if (! $note){
        abort();
        }
    - Soln
            $note = $db->query('select * from notes where id = :id', [
         'id' => $_GET['id']]
        )->fetch();
        
        if (! $note){
        abort();
        }
        
        if ($note['user_id'] != 1 ){
        abort(403);
        }
    Talk thhe mmagic numbers -.nnumber as significants  or special meaning.
                if ($note['user_id'] != 1 ){
                    abort(403);
                }
        TO
        $currentUserId = 1;

        if ($note['user_id'] != $currentUserId ){
        abort(403);
        }
    - Create a class called Respoonse.php, access the MAAGIC NUUMBER
        class Response
        {
        const  NOT_FOUND = 404;
        const  FORBIDDEN= 403;
        }

# PROGRAMMING IS REWRITING
     - Go back to Note controller
     - return $this in Database.php
             return    $this;
            //return  $statement;
     - Open the controllers/note.php , cause the problem ,wont be able to access the PDO
        access the Database 
      - assign the  pdo statemnt to the class
             public $statement;

     - Add some code in Dataabase class and function file (Database.php / functions.php)
            findOrFail()
            find()
            get()
            authorized()

# INTRODUCTION  FORMS AND REQUEST METHODS
        - Add the button to create a new note
        - extract  the routes to own file
        - Naming convention on routes 
        - Get / Post
           <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
           </div>
        - build the form

# ALWAYS ESCAPE UNTRUSTED  INPUT
    - take  tthe value and  insert to database
    - Add the logic inside the note-create.php
    - Fix the untruusted input
        Work on. <strong class="text=red-500 font-blod">something</strong>
    - SOLN
        Sanitize the body before itt goes into datbase
        allow the data to enter innto ddatabase and allow it to dissplay
            eg htmlspecialchars()
                    <p><?= $note['body']?></p>  to
                    <p><?= htmlspecialchars($note['body'])?></p>

# INTRODUCTION TO FORM VALIDATIONS
    - validate our data . eg user enter the empty data
    - client side browser  validation
    - curl -x POST http://localhost:8888/notes/create -d 'body='
    - server side validation
        eg controllers/note-create.php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $errors  = [];

    if (strlen($_POST['body']) == 0){
        $errors['body'] = 'A body is required';
    }

    if (empty($errors)){
        $db->query('INSERT INTO notes(body, user_id) VALUES (:body , :user_id)',[
            'body' => $_POST['body'],
            'user_id' => 1,
        ]);
    }

    }
    - Input 1000 text / max number of character we can allow
        if (strlen($_POST['body']) > 1000){
        $errors['body'] = 'The body can not be more than 1,000 characters';
    }
    - Keep tthe value
        <?= isset($_POST['body']) ? $_POST['body'] : '' ?>
        ORR  PHP 8.1
        <?= $_POST['body'] ?? '' ?><

 # EXTRACT A SIMPLE VALIDATOR CLASS
    - To extract the validation into its  own logic
            if (strlen($_POST['body']) == 0){
        $errors['body'] = 'A body is required';
        }
    
        if (strlen($_POST['body']) > 1000){
            $errors['body'] = 'The body can not be more than 1,000 characters';
        }

        

    - Pure function
            static classs Validator::


#   RESOURCEFUL  NAMING CONVENTIONS
        index()
        show()
        create()
    - Simple and cleaner for organization
        . Controller wee see three files delicated to notes same as views
        . Put aall notes in own directory   called notes     
                controllers/note.php
                controllers/note-create.php
                controllers/notes.php
    - Update the path oon routes
            routes.php

            return [
                '/'       => 'controllers/index.php',
                '/about'  => 'controllers/about.php',
                '/notes'  => 'controllers/notes.php',
                '/note'  => 'controllers/note.php',
                '/notes/create'  => 'controllers/note-create.php',
                '/contact' => 'controllers/contact.php',
            ];

    TO
        return [
            '/notes'  => 'controllers/notes/index.php',
            '/note'  => 'controllers/notes/show.php',
            '/notes/create'  => 'controllers/notes/create.php',
        ];

    - Update the path on views/notes
        views/notes/index.view.php
        views/notes/show.view.php
        views/notes/create.view.php

    - Update the path  in the controllers
                require 'views/create.view.php';

    - Update the partials  in the controllers
                1: Use the relative path to give the path of current file
                      <?php require(__DIR__. '/../partials/head.php') ?>          
                2: Use the FULL path ON thee system
                            <?php require('views/partials/head.php') ?>

# PHP AUTOLOADING AND EXTRACTIONS
         php  c
         php  -h
        c


    - project organisation
    - Open the router.php file
            var_dump('hello ');
            die();
      we can access the  route.ph file , big security issue concern
    - Change the Document root
        index.php will go there .
    - Create folder called public  and move index.php
        public/index.php\  
    - After mmoving  the index.php into public folder
         php  -S localhost:8888 -t public
    - Try to  access 
        http://localhost:8888/config.php
            Not Found
            The requested resource /config.php was not found on this server.
        Becase the public foldder is the  doc root

        http://localhost:8888/
            Warning: require(functions.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/public/index.php on line 4
        Because we moved into neew directorry
            require BASE_PATH .'functions.php';
            require BASE_PATH.'Database.php';
            require BASE_PATH.'Response.php';
            require BASE_PATH.'router.php';
    - Create  a path function  functions.php, we can use it inn the index.php
         
            require BASE_PATH.'Database.php';
            require BASE_PATH.'Response.php';
            require BASE_PATH.'router.php';
                TO
            require base_path('Database.php');
            require base_path('Response.php');
            require base_path('router.php');
    
        http://localhost:8888/
    ERROR
        Warning: require(views/index.view.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/controllers/index.php on line 7
    SOLUTION : controllers/notes/index.php
        Add the  base_path()
                
                require "views/index.view.php";
                require base_path("views/index.view.php");
    REMEMBER :Loading the view will be ddone constantly 
    So we need to aadd the helper function called view()
        function view($path)
            {
            return base_path('views/' . $path);
            }


        require view("index.view.php");
    What if we remove the require into  the views
        require view("index.view.php");
            function view($path)
            {
            require base_path('views/' . $path); ///views/index.view.php
            //return base_path('views/' . $path); ///views/index.view.php
            }

    error
        Warning: Undefined variable $heading in /Users/developer/Documents/code/website-application/views/partials/header.php on line 3
    solun
            controllers/index.php

           1:    view("index.view.php", [
                'heading' => $heading
                ]);

            2:    view("index.view.php", [
                    'heading' => 'Home'
                ]);

        EXTRACTION() Import variables into the current symbol table from an array
            function view($path, $attributes = [])
            {
            extract($attributes);
            require base_path('views/' . $path); ///views/index.view.php
            //return base_path('views/' . $path); ///views/index.view.php
            }


       EXTRACTION()  Accept an array and set into variables
        function view($path, $attributes = [])
        {
        extract($attributes);
        require base_path('views/' . $path); ///views/index.view.php
        //return base_path('views/' . $path); ///views/index.view.php
        }
    - Update  othe files like about.php

                $heading = "About Us";

            //require "views/about.view.php";
            
            view("about.view.php", [
            'heading' => 'About Us'
            ]);
    -  It will be slightly with notes folder : to  be done to all resourcefull
            require "views/notes/index.view.php" ; TO

                view("notes/index.view.php", [
                    'heading' => 'My Notes'
                ]);
    - I DONNT NEED TO ACCESS THE DB AND CONFI FROM THE VIEW

            <?php
            $config = require('config.php');
            $db = new Database($config['database']);

    -  TEST
        Warning: require(config.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/controllers/notes/index.php on line 2
        SOLN
            We require the document  root
                        
                $config = require('config.php');  TO
                $config = require base_path('config.php');
    - TEST
          Warning: require(views/partials/head.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/views/notes/index.view.php on line 1
            <?php require('views/partials/footer.php') ?>
        SOLUT  base_path()
             views/notes/index.view.php

                <?php require('views/partials/head.php') ?>
                <?php  require('views/partials/nav.php');?>
                <?php  require('views/partials/header.php');?>
                     TO
            <?php require base_path('views/partials/head.php') ?>
            <?php  require base_path('views/partials/nav.php');?>
            <?php  require base_path('views/partials/header.php');?>

    - TEST
           Warning: require(config.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/controllers/notes/show.php on line 2
            $config = require('config.php');
        SOLUTION
    
            $config = require base_path('config.php');

    TEST 
            Warning: require(Validator.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/controllers/notes/create.php on line 2
        SOLUTION
        controllers/notes/create.php
        require 'Validator.php';
        TO
        require base_path('Validator.php');

    TEST
        Warning: Undefined variable $errors in /Users/developer/Documents/code/website-application/controllers/notes/create.php on line 32
        
            SOLN
            Put  $errors  = []; at the top,
            

    GET LEAD OF DATABBSE AND RESPONSE
            public/index.php

            require base_path('Database.php');
            require base_path('Response.php');
            require base_path('router.php');

            TO

            require base_path('router.php');

        ERROR
            Fatal error: Uncaught Error: Class "Database" not found in /Users/developer/Documents/code/website-application/controllers/notes/index.php:3
        SOLUTION

            USE spl_autoload_register();

            spl_autoload_register(function ($class){
            dd($class);
        });

        spl_autoload_register(function ($class){
            var_dump(base_path($class. '.php'));
        });

            string(74) "/Users/developer/Documents/code/website-application/public/../Database.php"

        TEST PASS
        spl_autoload_register(function ($class){
            require base_path($class. '.php');
        });
    Note:
        Database, validator  and response are not related 
        We need to create a  folder called Core
            Move: Validator,Response,Database 
    TEST
            Warning: require(/Users/developer/Documents/code/website-application/public/../functions.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/public/index.php on line 6
    SOLN: 
        Open the autoloader
                public/index.php

                    spl_autoload_register(function ($class){
                        require base_path($class. '.php');
                    });
            TO
                 spl_autoload_register(function ($class){
                         require base_path("Core/" . $class. '.php');  or
                    });


            OR  - Option + return key select convert concatenation tto string interporation
                
                    spl_autoload_register(function ($class){
                        require base_path("Core/{$class}.php");
                    });


# NAMESPACING : WHAT , WHY HOW ? 
    https://www.w3schools.com/php/php_namespaces.asp
    Open the  Core/Database.php
    Add
        namespace  Core;
    Use controllers/notes/index.php
        use  Core\Database;
    Open public/index

        spl_autoload_register(function ($class){
        //Core\Database
        
            $class = str_replace('\\' , DIRECTORY_SEPARATOR , $class); //str_replace($search , $replace, $subject);
            //dd($result);
            require base_path("{$class}.php");
            //require base_path("Core/" . $class. '.php');
        });
    TEST
    
        Warning: require(/Users/developer/Documents/code/website-application/public/../Core/PDO.php): Failed to open stream: No such file or directory in /Users/developer/Documents/code/website-application/public/index.php on line 13

        TRYING TO FIND website-application/public/../Core/PDO.php

        \PDO:: START FROM THEE ROOT AAND LOOK FOR PDO
        PDO:: START WITHIN

# HANDLE MULTIPLE REQUEST METHODS FROM A CONTROLLER ACTION ?
    WHY: Derive tthe refactor of the code  .
    Advanced : request  types service container
    Ways to delete the notes
        Add the form and the button on the note
           views/notes/show.view.php
        
        Add the logic inside the show controller to delete  the record
            controllers/notes/show.php
                $db->query('delete  from notes where id = :id',[
                'id' => $_GET['id']
                ]);
            
                 header('location: /notes');
                 exit();

# BUILD A BETTER  ROUTER
    Enhannce our our router class to ssupport request types
            eg form and u want  submit a delete request to particular controller .
            routes.php
                    return [
                        '/'       => 'controllers/index.php',
                        '/about'  => 'controllers/about.php',
                        '/notes'  => 'controllers/notes/index.php',
                        '/note'  => 'controllers/notes/show.php',
                        '/notes/create'  => 'controllers/notes/create.php',
                        '/contact' => 'controllers/contact.php',
                    ];

                TO

                    return [
                        '/'       => '/',
                        'controller'  => 'controllers/index.php',
                        'method'  => 'GET'
                    ];
                THIS ISN'T GOOD ,

    - Use the  Router object , call the specific  request (GET POST PUT PATCH DELETE)
            $router->get('/' , 'controllers/index.php');
            $router->delete('/' , 'controllers/notes/destroy.php');
    -  Create  class called Router.php
            Core/Router.php
            Pushinng routes into array 
                $this->routes[] =[
                    'uri' => $uri,
                    'controller' => $controller,
                    'method'=>'DELETE'
                ];
    - We need to update  the old public/index.phpfile
        require base_path('Core/router.php'); This  has been delicated  to a class
    - The router object $router  = new \Core\Router(); will bee available into routes.php
    - Write  the route()  function in Core/Router.php
    - Add  the  hidden input on show.php
        <input type="hidden" name="_method" value="DELETE">
    - In public/indx
        $method = isset($_POST['_method']) ?  $_POST['_method']  :$_SERVER['REQUEST_METHOD']; old synntax
        $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    - final we loop all the routes created  routes.php
                public function route($uri, $method) //get delete put post request
                    {
                        foreach ($this->routes as $route){
                            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)){ // === match
                                return require  base_path($route['controller']);
                            }
                        }
                        //abort
                        $this->abort();
                    }
    - New synattax of routes
            $router->get('/notes' , 'controllers/notes/index.php');
            $router->get('/note' , 'controllers/notes/show.php');
            $router->get('/notes/create' , 'controllers/notes/create.php');

    - Add the helper method , reponsipble for pending into array
    
            public function  add($method , $uri , $controller)
            {
                $this->routes[] = compact('method' , 'uri' , 'controller');
                $this->routes[] =[
                    'uri' => $uri,
                    'controller' => $controller,
                     'method'=> $method
                    //'method'=>'GET'
                ];
            }

# ONE REQUEST , ONE CONTROLLER
    - To split out to its  own controller actions .
    - Add a new request
            $router->delete('/note' , 'controllers/notes/destroy.php');
    - Rename controllers/notes/show.php to controllers/notes/destroy.php
    - Rewrite tthe destroy function to it's own files.
    - Updated our router to listen and respond the requuest
    - create  the new post request to create a  UI
        $router->post('/notes' , 'controllers/notes/store.php');
    - Open the create ui file  views/notes/create.view.php add the action=""
    -AAdd the logic into controllers/notes/store.php
    - Remove other codde in controllers/notes/create.php


#  MAKE YOUR FIRST  SERVICE CONTAINER
    https://stackoverflow.com/questions/37038830/what-is-the-concept-of-service-container-in-laravel
    -complex 
    - We need to instantiate our daatabase in order to executee ouur db , we neeed too build up our necessary configuration
        to pass into constructor .config.php
            controllers/notes/destroy.php
        eg:
            $config = require base_path('config.php');
            $db = new Database($config['database']);
    - Very annoyed to call these every time when we want to use $db->query();
            example:
                $config = require base_path('config.php');
                $db = new Database($config['database']);
                    controllers/notes/create.php
                    controllers/notes/destroy.php
                    controllers/notes/index.php
                    controllers/notes/show.php
                    controllers/notes/store.php
    - Put in the container and use it  when it needed .
    - Creata a Container inside the Core folder
        add / bind        into container
        remove / resolve / grap   into container

    - create a file called bootstrap.php , then the index.php will  require  it .(public/index.php)
        require base_path('bootstrap.php');
    - AAdd logic into the bootstrap.php
                $container->bind('Core\Database', function (){  //setup the method signatuure

            $config = require base_path('config.php');
        
            return new Database($config['database']);
        
        });
    Accept two parameters 
             1: 'Core\Database' => key
             2: function ()=> Buildinng up the object eg $func , $buillder or $resolver
    Store/cache it 
    resolve() Take out the object out of the container,trigger the function and return the  results .

                        if (array_key_exists($key , $this->bindinngs)){
                        $resolver = $this->bindinngs[$key];
            
                        return call_user_func($resolver);
                            }
    Test our database class instance in bootstrap.php file
     RESULT:
        object(Core\Database)#4 (2) {
             ["connection"]=>
              object(PDO)#5 (0) {
            }
            ["statement"]=>
            NULL
            }
    We need to build up our conntainner somewhere and use it to our application.
    We need tto build app class in Core folder,  write a logic 
             protected  static  $container;
                public static function setContainer($container)
                {
                    static::$container = $container;
                }
            
            
                public static function container()
                {
                    return static::$container;
                }

    Go back to bootstrap.php
        App::setContainer($container);
    Test the application in controllers/notes/destroy.php

            Comment this code
            use Core\Database;
            $config = require base_path('config.php');
            $db = new Database($config['database']);
        
            Replace with
                

                $db = App::container()->resolve('Core\Database');
                
                dd($db);


            OR

            use Core\App;
            use Core\Database;

            $db = App::resolve(Database::class);

    Problem here is the  that , the resolve method is provided in the container not  in the App.php
    To overcome we need to add two method in App.php

            public static function bind($key, $resolver )
            {
                static::container()->bind($key, $resolver);
            }
            public static function resolve($key)
            {
                return static::container()->resolve($key);
            }
    Open the  controllers/notes/destroy.php
            use Core\App;
            use Core\Database;

            $db = App::resolve(Database::class);

    Tested  PASSED

    REPLACE TOO ALL CRUD IN CONTROLLER
            use Core\App;
            use Core\Database;
            
            
            $db = App::resolve(Database::class);

    SINGTOKE IN LARAVEL ,  AUTOTOMATIC DEPENDENCY INJECTION 

# UPDATING WITH PATCH REQUESTS
    - update the record if u made thhe mistake before posting .
    - Let us reuse the create vview form  create.view.php
    - Call it edit.view.php
    - Start with routes level
        $router->get('/note/edit' , 'controllers/notes/edit.php');
    - Create  the controller for edit , take we have and duplicate it 
        controllers/notes/edit.php
    - Add the edit link button to show.php file  views/notes/show.view.php
    - Passs the  id on the link buttton in show filee to be able to view whhich note we're deleting.
    - Add tthe  logic to grab the informattion froom tthe database .in controllers/notes/edit.php
    - Open the views/notes/edit.view.php
                look <?= $_POST['body'] ?? '' ?> and replace with 
                    <?= $note['body'] ?>
    -What  if I change my mind ? We need to add the cancel button
        views/notes/edit.view.php
    - Add thhe route to update the record
        $router->patch('/note' , 'controllers/notes/update.php');
    - Create the update controller
    -Add the action in the views/notes/edit.view.php aand hidden input
            action="/note"
            <input type="hidden" name="_method" value="PATCH">
    - Steps to follow when updating the recprd
            1: find  the corresponding note
            2: authorize that the current user can edit the note
            3: validate the form
            4: if no validation errors, update  the record in the database table

    - Pass the id of the node in UI <input type="hidden" name="id" value="<?= $note['id'] ?>">

    - REPEATING THE LOGIC ESPECIALL IN VALIDATION 
                eqDgequNh64G


# PHP SESSION 101 HANDLING 
    Session handlling and authentication .
    what is php session ? when the user interact with my website
    $_SESSION[]
    $_SESSION['name'] = "manyama"; will be remembereedd when i  browse the  website
    Not permanent
    Temporary , deletedd when u close thhe browser

    Test  
        controllers/notes/create.php
        controllers/about.php 
        $_SESSION['name'] = "manyama";
    error: Undefined global variable $_SESSION 
    SOLN:

        Always start with session() , in order to interact with supper global
        As sooner as possble  public/index.php
            session_start();

           $_SESSION['name'] = "manyama";
    -Doesnt live forever

    -  Cookies  storedd in browser  side  (client)
    - If i delete the coookie in browswee side , cookie dooesnnt trannsimitted 
    - File is beenn stored in the server , container abouutt the information of the server
        php --info
        Saaved session.save_path => no value => no value
    Terminal 
        echo  $TMPDIR
        /var/folders/77/8zv6t4z527q417gwy2ql8wlc0000gn/T/
    Written  to file  to aa server


#  REGISTER A NEW USER
        https://tailwindui.com/components/application-ui/forms/sign-in-forms
    - last epsioe was learn about tthe session
    - Create a new route  to create aa new user
    - Create  a controllers/registration/create.php
    - views/registration/create.view.php
        . Add validation error onn UI 
            <?php if (isset($errors['password'])) :?>
                <p class="text-red-500 text-sm mt-2"><?= $errors['password']?></p>
            <?php endif;?>
    - Onnce the user submoit the form goes to store  route
            $router->post('/register', 'controllers/registration/store.php');
    - Create the store controller
                controllers/registration/store.php
    - Within aabove we shouuld have $_POST[''] email and password



# INTRODUCTION TO MIDDLEWARE
    INITIAL BRIDGE WHICH TAKES  FROM INITIAL REQUEST  TO THE CORE OF APPLICATION
    THAT BRIDGE WILL GOING TO AUTHORIZE  THE USER 
            EG .Are u the guest or sign in 
    What if i retry to revist the resgister while I am already  logged in ?
    eg http://localhost:8888/register
    We need kind of protection while your logged in aleardy .
    We need to  restrict the user to view the ceertain pages
        eg Notes 
            http://localhost:8888/register
    Open the create.php iin controlller
            if ($_SESSION['user'] ?? false){
            header('location: /');
            exit();
        }
    This isnt the best idea ,let tackle in routes level  
        routes.php
        $router->get('/register', 'controllers/registration/create.php')->only('guest');
        Let opee the Core/Router.php  and the only() method function
        Try tto visit http://localhost:8888/register
            Error:
                Fatal error: Uncaught Error: Call to a member function only() on null in
            Resson
                TThee get method doesn't know anythong that why is returning this error message .
        We need  to add  the return $this; on the add($method , $uri , $controller)
        The return to all login 
        We can continue with the chain
            return $this->add('PUT' , $uri , $controller);

    TEST :
        http://localhost:8888/register   passed ,
        We getting  the authorization key middleware
    BRIDGE ----> CORE OF APPLICATION
    Associate the middleware with most  as route

    Implemment thee logic   route($uri, $method){}   Core/Router.php
            if ($route['middleware'] === 'guest'){
                    if ($_SESSION['user'] ?? false){
                        header('location: /');
                        exit();
                    }
                }
    Test the middleware
        $router->get('/register', 'controllers/registration/create.php')->only('guest');

    Fix the middlware for notes 
        $router->get('/notes' , 'controllers/notes/index.php')->only('auth');

    if ($route['middleware'] === 'auth'){
        if (! $_SESSION['user'] ?? false){
            header('location: /');
            exit();
        }
    }

    TEST : http://localhost:8888/notes 
     
    Let us create a folder called middleware directory, both of them will have handle method like  the contractt
        Core/Middleware/Auth.php
        Core/Middleware/Guest.php
    Extract the  code  to  each  middleware file

            if (! $_SESSION['user'] ?? false){
            header('location: /');
            exit();
       }
    Call the middlwaare  into Router.php
            (new Guest)->handle();
    
    But tthe above method isnt  to good , we need to create  lookup table  claass\
        Core/Middleware/Middleware.php
        const  MAP = [
           'guest' => Guest::class,
           'auth'  => Auth::class
      ];

    Thenn open again the Core/Router.php
        /**Apply  Middleware*/
                if ($route['middleware'] === 'guest'){  //$route['middleware'] === 'key' pint  to guest class
                    (new Guest)->handle();
                }

                /**Apply  Middleware*/
                if ($route['middleware'] === 'auth'){
                    (new Auth)->handle();
                }
        Replace WITH
            Middleware::MAP[$route[passing key]];
            Middleware::MAP[$route['middleware']];
        
            $middleware = Middleware::MAP[$route['middleware']];

                //Instantiate
           (new $middleware)->handle();
    This is more dynnamic 

    TEST
        http://localhost:8888/
        Warning: Undefined array key "" in /Users/developer/Documents/code/website-application/Core/Router.php on line 69

        SOLUT
        Create the check if(){}

            if ($route['middleware']){
                    $middleware = Middleware::MAP[$route['middleware']];

                    //Instantiate
                    (new $middleware)->handle();
                }
    We can imprrove the check again by middlewarre in Core/Router.php by implementing the resolve()0 in Middleware class Core/Middleware/Middleware.php

    public  static  function resolve($key)
            {
            if (!$key) {
            return;
            }
            //$middleware = static::MAP[$route['middleware']];
            $middleware = static::MAP[$key];
            
                  //Instantiate
                  (new $middleware)->handle();
            }

    Call the middleware  Core/Router.php
        Middleware::resolve($route['middleware']);
    BUT
    What if uu try to access the different middleware  which dowsnt exist?
        eg $router->get('/register', 'controllers/registration/create.php')->only('foo');

    http://localhost:8888/register

    error:
        Warning: Undefined array key "foo" in /Users/developer/Documents/code/website-application/Core/Middleware/Middleware.php on line 18
        Fatal error: Uncaught Error: Class name must be a valid object or a string 
    solution:
            Add the exception handler 

            if(! $middleware){
                  throw new \Exception('No matching middleware found for key'. $key . '.');
              }

    TEST 
        PASSED


# MANAGE PASSWORDS LIKE THIS FOR THE REMAINDER OF YOUR CAREER
    Passworrd Security and hashing
    -Show the person who logged in
        <p>Hello, <?= $_SESSION['user']['email'] ?? 'Guest' ?> Welcome to home page</p>
    -  Storing the passwoord inn clear text .NEVER STORE PASSWOORD IN CLEAR TEXT
    - Open the controllers/registration/store.php
        PASSWORD_DEFAULT OR PASSWORD_BCRYPT
        E.G
            'password' => password_hash($password, PASSWORD_BCRYPT),

        $db->query('INSERT INTO users (email, password) VALUES (:email, :password)',[
        'email'    => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT), //never store database password in clear  text
    ]);

# LOG IN AND LOG OUTS
    - We have user account , registration system , passwword hashing
    -  Timme to build the log inn form .
    - Open nav bar and add the link
            views/partials/nav.php
        Adds the  login link
    - Register the login link into the routes file
    - Create the controllers/sessions/create.php file
        .Load the view
    - Create the ui views/sessions/create.view.php
        . actions is action="/sessions" method="POST"
    - Create the store actions
    - Refactore the code in controllers/registration/store.php and add the login() {} 

                $_SESSION['user'] = [
                    'email' => $email
                ];

         login([
                'email' => $email
            ]);
            
        .Add the logic to store the session login
    - No reasonn to return view two  times  controllers/sessions/store.php
             if (!$user){
                return view('sessions/create.view.php',[
                'errors' => [
                    'email' => 'No matching account found for that email address'
                        ]
                    ]);
                }
        TO

        if ($user){

    /** we have a user , but we don't know if the password  provided matches what we have in the database*/
    if (password_verify($password, $user['password'])){
        login([
            'email' => $email
        ]);

        header('location: /');
        exit();
       }
    }

    PASSED
    - Add the last featured of logout funnctionality
    - Let go to nav file and add anchhor  tag for logout
        .Use the form insttead of anchhor tag
                <?php if ($_SESSION['user'] ?? false) : ?>
                        <div class="ml-3">
                            <form action="/session" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="text-white">Log Out</button>
                            </form>
                        </div>
                    <?php endif; ?>
    - Next step is create  a proper route for logout
            $router->delete('/session', 'controllers/session/destroy.php')->only('auth');
    - Add the logic to logout
        controllers/session/destroy.php
    - Create aa function logout to destroy the coookie
        Core/functions.php
    - To add the middleware to protect the notes

             <?php if ($_SESSION['user'] ?? false) : ?>
                            <a href="/notes" class="<?= urlIs('/notes') ?  'bg-gray-900 text-white' : 'text-gray-300'?> hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Notes</a>
              <?php endif;?>


# EXTRACT A FORM  VALIDATION OBJECT
    - process of refactoring our code 
    - CREATTIVITY
    - Open the controllers/session/store.php
        . Start with validation,
        .Think of the proper name called LoginForm and think of directory  
            .Http - entry point of our application
                    Http/Forms/LoginForm.php
    -Move the controller to our  Http folder
        Http/controllers
    - Update the route  path in routes.php after mooving controllers directory into Core folder
       remove the $router->get('/' , controllers/'index.php');
        To    $router->get('/' , 'index.php');

    TEST:
        Warning: require(/Users/developer/Documents/code/website-application/public/../index.php):
    SOLUUTION
        Go  to  Core/Router.php and change the base path
                return require  base_path($route['controller']); TO
                return require  base_path($route['controller']); 

    I HAVE SEPERATED THE UNIQUE TTO MY APPLICATION
    
    - create a class called the LoginForm.php inside the  forms directory  Http/Forms/LoginForm.php
        . Create a function caallled validate(){}
        . Move the validation error logic from Http/controllers/session/store.php
                $errors = [];
                    if (!Validator::email($email)){
                    $errors['email'] = 'Please provide a valid email address';
                    }
                    
                    if (!Validator::string($password)){
                    $errors['password'] = 'Please provide a password ';
                    }
                    
                    if (! empty($errors)){
                    return view('session/create.view.php',[
                    'errors' => $errors
                    ]);
                    }
            . call the object
                $form = new LoginForm();

                $form->validate($email, $password); //$atttributes

    - Do we nee the to load the view in my class ?NO ,REMOVE IT  Http/Forms/LoginForm.php
                if (! empty($errors)){
                    return view('session/create.view.php',[
                        'errors' => $errors
                    ]);
                }
    - I wantt  tto be simple  Http/Forms/LoginForm.php  annd Http/controllers/session/store.php
                $form = new LoginForm();

            /*form didn't validate*/
            if (! $form->validate($email, $password)){   //$atttributes
            
                return view('session/create.view.php',[
                    'errors' => $form->errors()
                ]);
            }

# EXTRACT AN AUTHENTICATOR CLASS
    open  Http/controllers/session/store.php
    Create the Authennticaator class called Authenticator  Core/Authenticator.php
        . move the logic from store into Authenticator class 
         .call thhe object  into store file

    Move the logic from function into authhenticaator cllass
        public function login($user)
        {
            $_SESSION['user'] = [
                'email' => $user['email']
            ];
    
            session_regenerate_id(true);
        }
    
        public function logout()
        {
            $_SESSION = []; //clear super global
            session_destroy();
    
            $params = session_get_cookie_params();
    
            setcookie('PHPSESSID', '' , time() -3600  ,$params['path'], $params['domain'], $params['secure'],$params['httponly']   );
    
        }

    Create a function to  redirectt  thhe path and call it  Core/functions.php

             header('location: /');
             exit();

    - if you  have a piece of code which looks the same but slightly difference , see if u ccan make identical.




        No matching account found for that email address and password
            Http/controllers/session/store.php

                return view('session/create.view.php',[
                        'errors' => $form->errors()
                    ]);
                    
                return view('session/create.view.php',[
                'errors' => [
                    'email' => 'No matching account found for that email address and password'
                ]
         ]);
    Once  they're  identicall we caan merge them
     1: Create a function called error  Http/Forms/LoginForm.php and add the logic
     2: Merge  into one
            if (! $form->validate($email, $password)){   //$atttributes

                /** log in  the user if the credentials match*/
                $auth = new  Authenticator();
            
                if (!$auth->attempt($email, $password )) {
                    redirect('/');
                }else{
                    //append
                    $form->error('error', 'No matching account found for that email address and password');
                }
            }

        OR NEW VERSION
            if ($form->validate($email, $password)){
                if ((new Authenticator)->attempt($email, $password )){
                    redirect('/');
                }else{
                    $form->error('error', 'No matching account found for that email address and password');
                }
            }

# THE PRG PATTERN (and SESSION FLASHING)
        P - POST REQUEST
        R - REDIRECT - SEND A NEW FORM
        G - GET
    - redirect too return redirect('/login');  Http/controllers/session/store.php
    - Deeall with errors

# FLASH OLD FORM DATA  TO THE SESSION
    Http/controllers/session/create.php
        value="<?= $_SESSION['_flash']['old']['email'] ?? '' ;?>"
        Core/functions.php
        views/session/create.view.php
        Core/Session.php
        Core/Authenticator.php
        Http/controllers/session/store.php

# AUTIMATICALLY REDIRECT BACK UPON  FAILEDD VALIDATION
    Open Http/controllers/session/store.php

# COMPOSER AND FREE  AUTOLOADING
    https://getcomposer.org/
    What is  composer ? A Dependency Manager for PHP
    It offer the possiblity to install php package .
        https://packagist.org/
    Package is the code , collection of file ,make available in world .
    Install the https://getcomposer.org/download/
    Terminal
        composer init
        composer install
    TEST
        http://localhost:8888/login
    error: 
        Fatal error: Uncaught Error: Class "Core\Container" not found in
    So how do we make the use of the contaainer?
        "autoload": {
        "psr-4": {
            "Core": "Core/"
        }
    }
    composer dump-autoload  will populate autoload files
    1: Top level
        Core
        Http
        composer dump-autoload
    Open the public/index.php
        .comment the 

        

        spl_autoload_register(function ($class){
                    // Core\Database
                //dd($class);
                $class = str_replace('\\' , DIRECTORY_SEPARATOR , $class); //str_replace($search , $replace, $subject);
                //dd($class);
                require base_path("{$class}.php");
                //require base_path("Core/" . $class. '.php');
                });
        Use the auttoload fromm package
            require BASE_PATH . '/vendor/autoload.php';

# INSTALL TWO COMMPOSER PACKAGES 
    by  web https://packagist.org/packages/illuminate/collections
    by terminal  composer search collections  

# Testing Approaches, Terms, and Considerations
    tests/Feature : Muchh wider  eg referal system 
    tests/Unit : can be a single class, function , small collection of classes
    browser test
    


            
    

        





























        













































































            
            

            







































    

















































        
        









































































































































        


































    

























