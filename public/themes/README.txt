

Each theme has separate dir, ex. 'default' inside which following are mandatory:
- css (containing custom css files)
- js (containing custom js files)
- img (...) 
- fonts (...)
(matches structure in 'public' module)
This dir will override application layout.


Also each theme dir should contain 'view' dir containing:
- <module name>
    - <action name>
        - index.phtml
- error
    - error.phtml
- layout
    - layout.phtml
This dir will override concrete module layouts.