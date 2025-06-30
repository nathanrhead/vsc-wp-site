( function( wp ) {
  const { addFilter } = wp.hooks;
  const { createHigherOrderComponent } = wp.compose;
  const { InspectorControls } = wp.blockEditor || wp.editor;
  const { PanelBody, TextControl } = wp.components;
  const el = wp.element.createElement;

  const addCustomControls = createHigherOrderComponent(function(BlockEdit) {
    return function(props) {
      if (props.name !== 'responsive-block-editor-addons/post-carousel') {
        return el(BlockEdit, props);
      }

      return el(
        wp.element.Fragment,
        {},
        el(BlockEdit, props),
        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            { title: 'Custom Query Filters', initialOpen: true },
            el(TextControl, {
              label: 'Post Type',
              value: props.attributes.customPostType || '',
              onChange: function(value) {
                props.setAttributes({ customPostType: value });
              },
            }),
            el(TextControl, {
              label: 'Categories to Include (comma separated)',
              value: (props.attributes.customCategories || []).join(', '),
              onChange: function(value) {
                // store as array of strings
                props.setAttributes({ customCategories: value.split(',').map(v => v.trim()).filter(Boolean) });
              },
            }),
            el(TextControl, {
              label: 'Categories to Exclude',
              value: props.attributes.keywordExclude || '',
              onChange: function(value) {
                props.setAttributes({ keywordExclude: value });
              },
            })
          )
        )
      );
    };
  }, 'addCustomControls');

  addFilter(
    'editor.BlockEdit',
    'responsive/post-carousel-custom-controls',
    addCustomControls
  );

  console.log('✅ Custom controls for post carousel block loaded');
} )( window.wp );