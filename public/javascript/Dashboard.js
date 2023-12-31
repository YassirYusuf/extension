// Toggle comment section in a post
document.addEventListener('DOMContentLoaded', (event) => {
    let blogCommentButtons = document.querySelectorAll('.blog-comment-btn');
    let deletePostButtons = document.querySelectorAll('.delete-post-btn');
    let deleteCommentButtons = document.querySelectorAll('.delete-comment-btn');

    blogCommentButtons.forEach(button => {
        button.addEventListener('click', function() {
            let postId = this.getAttribute('data-post-id');
            toggleCommentSection(postId);
        });
    });

    deletePostButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            let formId = this.getAttribute('data-form-id');
            deletePost(event, formId);
        });
    });

    deleteCommentButtons.forEach(button => {
        button.addEventListener('click', function() {
            let formId = this.getAttribute('data-form-id');
            deleteComment(event, formId);
        });
    });
});


function toggleCommentSection(postId) {
    var commentSection = document.getElementById('comment-section-' + postId);
    if (commentSection.style.display === 'none' || commentSection.style.display === '') {
        commentSection.style.display = 'block';
    } else {
        commentSection.style.display = 'none';
    }
}

// Delete a post
function deletePost(event, formId) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure? you want to delete this post',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

// Delete a comment
function deleteComment(event, formId) {
    console.log(formId)
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log(document.getElementById(formId));
            document.getElementById(formId).submit();
        }
    });
}
