(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { InspectorControls, InnerBlocks } = wp.blockEditor || wp.editor;
  const { PanelBody, TextControl } = wp.components;
  const { createElement: el, Fragment, useEffect } = wp.element;
  const { select, dispatch } = wp.data;

  registerBlockType('custom/post-carousel-wrapper', {
    title: 'Post Carousel Wrapper',
    icon: 'format-gallery',
    category: 'layout',
    attributes: {
      postType: { type: 'string', default: 'post' }
    },
    edit: function (props) {
      const { attributes, setAttributes, clientId } = props;
      const { postType } = attributes;

      useEffect(() => {
        const innerBlocks = select('core/block-editor').getBlock(clientId)?.innerBlocks || [];

        innerBlocks.forEach((block) => {
          if (block.name === 'responsive-block-editor-addons/post-carousel') {
            dispatch('core/block-editor').updateBlockAttributes(block.clientId, {
              postType: postType
            });
          }
        });
      }, [postType, clientId]);

      return el(Fragment, {},
        el(InspectorControls, {},
          el(PanelBody, { title: 'Carousel Settings', initialOpen: true }, [
            el(TextControl, {
              label: 'Post Type',
              value: postType,
              onChange: val => setAttributes({ postType: val })
            })
          ])
        ),
        el(InnerBlocks, {
          allowedBlocks: ['responsive-block-editor-addons/post-carousel'],
          template: [['responsive-block-editor-addons/post-carousel']],
          templateLock: 'all'
        })
      );
    },
    save: function () {
      return el(InnerBlocks.Content);
    }
  });
})(window.wp);