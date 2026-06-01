# Build Workflow

This plugin has a local webpack setup for the Divi visual builder preview bundle.

Run commands from this directory:

```bash
cd wp-content/plugins/divi-product-category-menu
```

Install dependencies:

```bash
npm install
```

Start watch mode for development:

```bash
npm run dev
```

Create the production bundle:

```bash
npm run build
```

Source files live in `visual-builder/src`.
The generated bundle is written to `assets/js/dpcm-visual-builder.js`.
