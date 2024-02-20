@extends('layouts.app')

@push('styles')
@endpush
@section('content')
    <div class="container">
        <h1>Create Video</h1>

        <form action="{{ route('videos.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="video" class="form-label">Video:</label>
                <input type="file" class="form-control" id="video" name="video" accept="video/*" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control tinyarea" id="content" name="content" rows="5"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="twitterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Twitter Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="">Example : https://publish.twitter.com/?url=https://twitter.com/MJ_Bishnoi_/status/1759234889810067502#</label>
                    <input type="text" class="form-control" id="twitterpost" placeholder="Enter post url" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addtwittercontent">Add</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="tinymce_item">
@endsection

@push('scripts')
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script src="https://cdn.tiny.cloud/1/ku26yeyqf2gbwbg4gwvouxnov9r9w3eaqgqtbs2fj3gaolmx/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var rootfolder = '<?php echo URL('/'); ?>';
        tinymce.init({
            entity_encoding: 'raw',
            height: "500",
            forced_root_block: "",
            force_br_newlines: true,
            force_p_newlines: false,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            //content_css: rootfolder + "/tinymce/tinymce_custom.css",
            selector: '.tinyarea:not(.textarea)',
            end_container_on_empty_block: true,
            menubar: true,
            toolbar: true,
            verify_html: true,
            plugins: [
                'table', 'code', 'table'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | help | twitter | code | table',
            valid_elements: '*[*]',
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
                editor.ui.registry.addButton('twitter', {
                    text: 'Twitter',
                    icon: 'embed-page',
                    context: 'twitter',
                    onAction: function(_) {
                        $('#tinymce_item').val(editor.id);
                        $('#twitterModal').modal('show');
                    }
                });
            }
        });

        $('body').on('click', '#addtwittercontent', function() {
            var postId = $('#twitterpost').val();
            if(postId == '')
            {
                alert('Enter post id');
                return;
            }
            var html = '<blockquote class="twitter-tweet"><a href="https://twitter.com/username/status/'+postId+'">Twitter Post: '+postId+'</a></blockquote></br>'
            var editor = $('#tinymce_item').val();
            tinymce.get(editor).execCommand('mceInsertContent', false, html);
            $('#twitterpost').val('');
            $('.modal').modal('hide');
        });
    </script>
@endpush
