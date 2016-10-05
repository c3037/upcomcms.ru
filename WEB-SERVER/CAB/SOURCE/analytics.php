<script>
var user_id = <?php echo (isset($data['user_id'])) ? $data['user_id'] : 0; ?>;
function event_feedback(){ return true; }
function event_send_counters_values(){ return true; }
</script> 

<?php
// echo APP_VERSION;
// echo APP_ID; 
?>