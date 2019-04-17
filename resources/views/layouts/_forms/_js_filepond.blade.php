{{--

$id = File Input ID

--}}
FilePond.registerPlugin(
FilePondPluginFileValidateType,
FilePondPluginImageExifOrientation,
FilePondPluginImagePreview,
FilePondPluginImageCrop,
FilePondPluginImageResize,
FilePondPluginImageTransform,
FilePondPluginImageEdit
);

FilePond.create(
document.querySelector('#{{ $id }}'),
{
labelIdle: `Drag & Drop an image here or <span class="filepond--label-action">Browse</span>`,
imagePreviewHeight: 200,
styleLoadIndicatorPosition: 'center bottom',
styleProgressIndicatorPosition: 'right bottom',
styleButtonRemoveItemPosition: 'left bottom',
styleButtonProcessItemPosition: 'right bottom',

server: {
process: '/api/store_file',
},

// Use Doka.js as image editor
imageEditEditor: Doka.create()
}
);