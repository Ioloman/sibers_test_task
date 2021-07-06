<!-- footer, includes passed scripts -->

<footer class="container">
        <hr>
        <p>&copy; iCal Network 2020-2021</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<?php if (isset($scripts)): ?> 

<?php foreach ($scripts as $script): ?>
<script src="<?php echo $script ?>"></script>
<?php endforeach; ?>

<?php endif; ?>

</body>
</html>