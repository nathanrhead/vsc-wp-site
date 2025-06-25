const { registerBlockType } = wp.blocks;
const { useBlockProps, InnerBlocks, InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, ToggleControl } = wp.components;
const { useState, createElement: el, Fragment } = wp.element;
const { __ } = wp.i18n;

registerBlockType('responsive-child/link-to-content', {
  edit({ attributes, setAttributes }) {
    const { url, rel, opensInNewTab } = attributes;

    return el(Fragment, null,
      el(InspectorControls, null,
        el(PanelBody, { title: __('Link Settings') },
          el(TextControl, {
            label: __('URL'),
            value: url,
            onChange: (newUrl) => setAttributes({ url: newUrl }),
            placeholder: 'https://example.com'
          }),
          el(TextControl, {
            label: __('Rel attribute'),
            value: rel,
            onChange: (newRel) => setAttributes({ rel: newRel }),
            placeholder: 'noopener noreferrer'
          }),
          el(ToggleControl, {
            label: __('Open in new tab'),
            checked: opensInNewTab,
            onChange: (newValue) => setAttributes({ opensInNewTab: newValue })
          })
        )
      ),
      el(
        'div',
        useBlockProps(),
        el(
          'div',
          {
            style: {
              border: '1px dashed #ccc',
              padding: '1em',
              backgroundColor: '#f9f9f9',
              minHeight: '50px',
            }
          },
          el(
            'strong',
            {
              style: {
                display: 'block',
                marginBottom: '0.5em',
                color: '#666',
                fontSize: '0.9em'
              }
            },
            url ? __('Linked Content') : __('Drop blocks here to link')
          ),
          url
            ? el(
                'a',
                {
                  href: url,
                  target: opensInNewTab ? '_blank' : undefined,
                  rel: rel,
                },
                el(InnerBlocks)
              )
            : el(InnerBlocks)
        )
      )
    );
  },

  save({ attributes }) {
    const { url, rel, opensInNewTab } = attributes;

    return el(
      'div',
      null,
      url
        ? el(
            'a',
            {
              href: url,
              target: opensInNewTab ? '_blank' : undefined,
              rel: rel,
            },
            el(InnerBlocks.Content)
          )
        : el(InnerBlocks.Content)
    );
  }
});