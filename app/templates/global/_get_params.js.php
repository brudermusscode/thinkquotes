<script>
  <?php

  echo "let __get_params = {\n";
  foreach ($get_params ?? [] as $key => $gp)
    echo $key . ": " . '"' . $gp . '",' . "\n";
  echo "};\n\n";

  ?>
</script>