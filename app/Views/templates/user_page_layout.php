<!DOCTYPE html>
<html lang="en">

<?= $this->include('templates/head') ?>

<body>
   <div>
      <?= $this->include('templates/user_sidebar') ?>
      <div class="main-panel">

         <?= $this->include('templates/user_navbar') ?>

         <?= $this->renderSection('content') ?>

         <?= $this->include('templates/footer') ?>

      </div>
   </div>
</body>

</html>