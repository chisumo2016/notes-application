<?php require base_path('views/partials/head.php') ?>
<?php  require base_path('views/partials/nav.php');?>
<?php  require base_path('views/partials/header.php');?>

    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">


            <ul>
                <?php foreach ($notes as $note) : ?>
                    <li>
                        <a href="/note?id=<?= $note['id']?>" class="text-blue-500 hover:underline">
                            <?= htmlspecialchars($note['body'])?>
                        </a>

                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="mt-6">
                <a href="/notes/create" class="text-blue-500 underline">Create Note</a>
            </div>
        </div>
    </main>

<?php require base_path('views/partials/footer.php') ?>

<!--<a href="/notes/create" class="text-blue-500 underline">Create Note</a>-->
