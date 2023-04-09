$(document).ready(function() {
    $('.changeStatus').click(function(e) {
        e.preventDefault();
        let id = $(this).closest('tr').data('id');
        let parent = $(this).parent();
        $.ajax({
            url: '/todo/completed',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    parent.html('done');
                }
                else {
                    alert('Error: ' + data.error);
                }
            }
        });
    });

    $('.edit-btn').click(function(e) {
        e.preventDefault();
        let mainBlock = $(this).closest('tr'),
            editBlock = mainBlock.find('.editable-area'),
            id = mainBlock.data('id'),
            parentBlock = $(this).parent(),
            nextBlock = parentBlock.next();

        parentBlock.hide();
        nextBlock.show();
        editBlock.data('oldtext', editBlock.text());
        editBlock.attr('contenteditable', 'true');
        editBlock.focus();
    });

    $('.save-btn').click(function(e) {
        let mainBlock = $(this).closest('tr'),
            id = mainBlock.data('id'),
            editBlock = mainBlock.find('.editable-area'),
            parentBlock = $(this).parent(),
            editedStatus = mainBlock.find('.edited-status'),
            prevBlock = parentBlock.prev();

        $.ajax({
            url: '/todo/edit',
            type: 'POST',
            data: {id: id, description: editBlock.text()},
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    editBlock.attr('contenteditable', 'false');
                    editedStatus.removeClass('hidden');
                    parentBlock.hide();
                    prevBlock.show();
                }
                else {
                    alert('Error: ' + data.error);
                }
            }
        });
    });

    $('.cancel-btn').click(function(e) {
        e.preventDefault();
        let parentBlock = $(this).parent();
        let prevBlock = parentBlock.prev();
        let mainBlock = $(this).closest('tr');
        let editBlock = mainBlock.find('.editable-area');

        parentBlock.hide();
        prevBlock.show();

        editBlock.attr('contenteditable', 'false');
        editBlock.text(editBlock.data('oldtext'));
    });
});