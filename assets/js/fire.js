$(document).ready(function() {
    // Controllers
    $('#add-controller-action').click(function() {
        $('<p> <input type="text" name="actions[]" value=""  /> <a href="#" class="remove-controller-action">Remove</a> </p>').appendTo('#controller-actions');
    });

    $('.remove-controller-action').live('click', function() {
        $(this).parent().remove();
    });

    // Models
    $('#add-table-column').click(function() {
        $('<p> <input type="text" name="columns[]" value=""  /> <select name="types[]"> <option value="varchar">VARCHAR</option> <option value="text">TEXT</option> <option value="char">CHAR</option> <option value="int">INT</option> <option value="decimal">DECIMAL</option> <option value="date">DATE</option> <option value="datetime">DATETIME</option> </select> <a href="#" class="remove-table-column">Remove</a> </p>').appendTo('#table-columns');
    });

    $('.remove-table-column').live('click', function() {
        $(this).parent().remove();
    });

    // Migrations
    $('#generate-migration-checkbox').click(function() {
        if ($(this).prop("checked"))
        {
            $(this).parent().after('<p id="parent-migration-container"><label for="parent-migration">Parent Migration:</label> <input type="text" name="parent_migration" id="parent-migration" value="CI_Migration"></p>');
        }
        else
        {
            $("#parent-migration-container").remove();
        }
    });
});
