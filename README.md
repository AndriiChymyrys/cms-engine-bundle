# WM CMS Engine

## Install
### Assets
After install vendor you have to manually enable front assets to work correctly.

1. To enable components. Add row in file `assets/js/App/App.js` to block `Import Components`
```javascript
import CmsEngineComponents from '../../../vendor/widemorph/cms-engine-bundle/Resources/assets/js/App/Component/components';
```
and in block `Register Components` add row
```javascript
registerComponents(app, CmsEngineComponents)
```
2. To enable store. In file `assets/js/App/Store.js` add import statement with cms engine store
```javascript
import CmsEngine from '../../../vendor/widemorph/cms-engine-bundle/Resources/assets/js/App/Store/store';
```
and update const modules by adding `CmsEngine store`
```
const modules = {
    ...
    'cmsEngine': CmsEngine,
    ...
};
```
3. To register cms engine lib. In file `assets/app.js` add import row
```javascript
import '../vendor/widemorph/cms-engine-bundle/Resources/assets/js/App/Lib/lib';
```

