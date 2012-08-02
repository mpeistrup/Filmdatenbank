 function showDialog($id, $title)
 {
   if (confirm('Are you shure?'))
   { 
     alert($id);
   } else {
     alert($title);
   }
 }