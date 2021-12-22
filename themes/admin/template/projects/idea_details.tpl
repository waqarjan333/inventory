 <table class="form">
    <tr>
      <td colspan="2">Following are the Idea details</td> 
    </tr> 
    <tr>
        <td colspan="2">Title </td> 
        <td colspan="2"><?php print $idea_info['ideadetails']['idea_title']; ?> [Created on <?php print $idea_info['ideadetails']['created_date']; ?> ]</td>
    </tr>
    <tr>
        <td colspan="2">Submited by</td> 
        <td colspan="2"><?php print $idea_info['ideauser']['fullname'] .' ('.$idea_info['ideauser']['fullname'].')'; ?></td>
    </tr>
    <tr>
        <td colspan="2">phone no</td> 
        <td colspan="2"><?php print $idea_info['ideauser']['phone_no']; ?></td>
    </tr>
    <tr>
        <td colspan="2">Description</td> 
        <td colspan="2"><?php print $idea_info['ideadetails']['idea_description']; ?></td>
    </tr> 
 </table> 