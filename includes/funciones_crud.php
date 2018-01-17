<script type="text/javascript">

// Editar
  function edit_id(id)
  {
    window.location.href='<?php echo $sec?>_edit.php?edit_id='+id+'&pagant=<?php echo $pagact?>';
  }

//Eliminar  
  function delete_id(id)
  {
    if(confirm('Segur que vol eliminar el registre?'))
    {
      window.location.href='<?php echo $pagact?>?delete_id='+id;
    }
  }
</script>
