/**
 * `HowtoTabs` is a container element for tabs and panels.
 *
 * All children of `<howto-tabs>` should be either `<howto-tab>` or
 * `<howto-tabpanel>`. This element is stateless, meaning that no values are
 * cached and therefore, changes during runtime work.
 */

export class HowtoTabsConnexion extends HTMLElement {
    //Les attribut de la classe
    private KEYCODE = {
        DOWN: 40,
        LEFT: 37,
        RIGHT: 39,
        UP: 38,
        HOME: 36,
        END: 35
    };
    private template: HTMLTemplateElement = document.createElement('template');

    constructor() {
        super();

        this.template.innerHTML = `
        <style>
        
        :host {
            display: flex;
            flex-wrap: wrap;
            margin: 3em 0;
        }
        ::slotted(howto-panel) {
            flex-basis: 100%;
        }
       
        ::slotted([role="tab"]) {
            position: relative;
            margin: 0;
            padding: .3em .5em .4em;
            border: 1px solid #851139;
            box-shadow: 0 0 .2em #851139;
            overflow: visible;
            font-family: inherit;
            font-size: inherit;
            background: hsl(220, 20%, 94%);
           width: 50%;
        }
        ::slotted([role="tab"]:hover)::before,
        ::slotted([role="tab"]:focus)::before,
        ::slotted([role="tab"][aria-selected="true"])::before {
            position: absolute;
            bottom: 100%;
            right: -1px;
            left: -1px;
            border-bottom: 4px solid #851139;
            content: '';
        }

        ::slotted([role="tab"][aria-selected="true"]) {
            border-radius: 0;
            background: hsl(220, 43%, 99%);
            outline: 0;
        }

        /*::slotted([role="tab"][aria-selected="true"]:not(:focus):not(:hover))::before {
           border-top: 5px solid yellow;
        }*/

        ::slotted([role="tab"][aria-selected="true"])::after {
            position: absolute;
            z-index: 3;
            bottom: -1px;
            right: 0;
            left: 0;
            height: .3em;
            background: hsl(220, 43%, 99%);
            box-shadow: none;
            content: '';
            
        }

        ::slotted([role="tab"]:hover),
        ::slotted([role="tab"]:focus),
       ::slotted([role="tab"]:active) {
            outline: 0;
            border-radius: 0;
            color: inherit;
            border-top: 4px solid #851139;
            
        }

     

        ::slotted([role="tabpanel"]) {
            position: relative;
            z-index: 2;
            padding: .5em .5em .7em;
            /*border: 1px solid hsl(219, 1%, 72%);*/
            border-left: 1px solid #851139;
            border-right: 1px solid #851139;
            border-bottom: 3px solid #851139;
            box-shadow: 0 0 .2em #851139;
            background: hsl(220, 43%, 99%);
        }

        ::slotted([role="tabpanel"]) p {
            margin: 0;
        }

        ::slotted([role="tabpanel"]) * + p {
            margin-top: 1em;
        }
        </style>
        <slot name="tab"></slot>
        <slot name="panel"></slot>
      `;


        // For progressive enhancement, the markup should alternate between tabs
        // and panels. Elements that reorder their children tend to not work well
        // with frameworks. Instead shadow DOM is used to reorder the elements by
        // using slots.
        this.attachShadow({mode: 'open'});
        // Import the shared template to create the slots for tabs and panels.
        this.shadowRoot.appendChild(this.template.content.cloneNode(true));

        this._tabSlot = this.shadowRoot.querySelector('slot[name=tab]');
        this._panelSlot = this.shadowRoot.querySelector('slot[name=panel]');

    }

    /**
     * `connectedCallback()` groups tabs and panels by reordering and makes sure
     * exactly one tab is active.
     */
    public connectedCallback(): void {

        // The element needs to do some manual input event handling to allow
        // switching with arrow keys and Home/End.
        this.addEventListener('keydown', this._onKeyDown);
        this.addEventListener('click', this._onClick);

        if (!this.hasAttribute('role'))
            this.setAttribute('role', 'tablist');

        // Up until recently, `slotchange` events did not fire when an element was
        // upgraded by the parser. For this reason, the element invokes the
        // handler manually. Once the new behavior lands in all browsers, the code
        // below can be removed.
        Promise.all([
            customElements.whenDefined('howto-tab'),
            customElements.whenDefined('howto-panel'),
        ])
            .then(_ => this._linkPanels());
    }

    /**
     * `disconnectedCallback()` removes the event listeners that
     * `connectedCallback` added.
     */
    public disconnectedCallback(): void {
        this.removeEventListener('keydown', this._onKeyDown);
        this.removeEventListener('click', this._onClick);
    }

    /**
     * `_linkPanels()` links up tabs with their adjacent panels using
     * `aria-controls` and `aria-labelledby`. Additionally, the method makes
     * sure only one tab is active.
     *
     * If this function becomes a bottleneck, it can be easily optimized by
     * only handling the new elements instead of iterating over all of the
     * element’s children.
     */
    private _linkPanels() {
        const tabs = this._allTabs();
        // Give each panel a `aria-labelledby` attribute that refers to the tab
        // that controls it.
        tabs.forEach(tab => {
            const panel = tab.nextElementSibling;
            if (panel.tagName.toLowerCase() !== 'howto-panel') {
                console.error(`Tab #${tab.id} is not a` +
                    `sibling of a <howto-panel>`);
                return;
            }

            tab.setAttribute('aria-controls', panel.id);
            panel.setAttribute('aria-labelledby', tab.id);
        });

        // The element checks if any of the tabs have been marked as selected.
        // If not, the first tab is now selected.
        const selectedTab =
            tabs.find(tab => tab.selected) || tabs[0];

        // Next, switch to the selected tab. `selectTab()` takes care of
        // marking all other tabs as deselected and hiding all other panels.
        this._selectTab(selectedTab);
    }

    /**
     * `_allPanels()` returns all the panels in the tab panel. This function
     * could memoize the result if the DOM queries ever become a performance
     * issue. The downside of memoization is that dynamically added tabs and
     * panels will not be handled.
     *
     * This is a method and not a getter, because a getter implies that it is
     * cheap to read.
     */
    private _allPanels() {
        return Array.from(this.querySelectorAll('howto-panel'));
    }

    /**
     * `_allTabs()` returns all the tabs in the tab panel.
     */
    private _allTabs() {
        return Array.from(this.querySelectorAll('howto-tab'));
    }

    /**
     * `_panelForTab()` returns the panel that the given tab controls.
     */
    private _panelForTab(tab) {
        const panelId = tab.getAttribute('aria-controls');
        return this.querySelector(`#${panelId}`);
    }

    /**
     * `_prevTab()` returns the tab that comes before the currently selected
     * one, wrapping around when reaching the first one.
     */
    private _prevTab() {
        const tabs = this._allTabs();
        // Use `findIndex()` to find the index of the currently
        // selected element and subtracts one to get the index of the previous
        // element.
        let newIdx =
            tabs.findIndex(tab => tab.selected) - 1;
        // Add `tabs.length` to make sure the index is a positive number
        // and get the modulus to wrap around if necessary.
        return tabs[(newIdx + tabs.length) % tabs.length];
    }

    /**
     * `_firstTab()` returns the first tab.
     */
    private _firstTab() {
        const tabs = this._allTabs();
        return tabs[0];
    }

    /**
     * `_lastTab()` returns the last tab.
     */
    private _lastTab() {
        const tabs = this._allTabs();
        return tabs[tabs.length - 1];
    }

    /**
     * `_nextTab()` gets the tab that comes after the currently selected one,
     * wrapping around when reaching the last tab.
     */
    private _nextTab() {
        const tabs = this._allTabs();
        let newIdx = tabs.findIndex(tab => tab.selected) + 1;
        return tabs[newIdx % tabs.length];
    }

    /**
     * `reset()` marks all tabs as deselected and hides all the panels.
     */
    public reset(): void {
        const tabs = this._allTabs();
        const panels = this._allPanels();

        tabs.forEach(tab => tab.selected = false);
        panels.forEach(panel => panel.hidden = true);
    }


    /**
     * `_selectTab()` marks the given tab as selected.
     * Additionally, it unhides the panel corresponding to the given tab.
     */
    private _selectTab(newTab): void {
        // Deselect all tabs and hide all panels.
        this.reset();

        // Get the panel that the `newTab` is associated with.
        const newPanel = this._panelForTab(newTab);
        // If that panel doesn’t exist, abort.
        if (!newPanel)
            //throw new Error(`No panel with id ${newPanelId}`);
            throw new Error(`No panel with id ${newPanel.id}`);
        newTab.selected = true;
        newPanel.hidden = false;
        newTab.focus();
    }

    /**
     * `_onKeyDown()` handles key presses inside the tab panel.
     */
    private _onKeyDown(event) {
        // If the keypress did not originate from a tab element itself,
        // it was a keypress inside the a panel or on empty space. Nothing to do.
        if (event.target.getAttribute('role') !== 'tab')
            return;
        // Don’t handle modifier shortcuts typically used by assistive technology.
        if (event.altKey)
            return;

        // The switch-case will determine which tab should be marked as active
        // depending on the key that was pressed.
        let newTab;
        switch (event.keyCode) {
            case this.KEYCODE.LEFT:
            case this.KEYCODE.UP:
                newTab = this._prevTab();
                break;

            case this.KEYCODE.RIGHT:
            case this.KEYCODE.DOWN:
                newTab = this._nextTab();
                break;

            case this.KEYCODE.HOME:
                newTab = this._firstTab();
                break;

            case this.KEYCODE.END:
                newTab = this._lastTab();
                break;
            // Any other key press is ignored and passed back to the browser.
            default:
                return;
        }

        // The browser might have some native functionality bound to the arrow
        // keys, home or end. The element calls `preventDefault()` to prevent the
        // browser from taking any actions.
        event.preventDefault();
        // Select the new tab, that has been determined in the switch-case.
        this._selectTab(newTab);
    }

    /**
     * `_onClick()` handles clicks inside the tab panel.
     */
    private _onClick(event) {
        // If the click was not targeted on a tab element itself,
        // it was a click inside the a panel or on empty space. Nothing to do.
        if (event.target.getAttribute('role') !== 'tab')
            return;
        // If it was on a tab element, though, select that tab.
        this._selectTab(event.target);
    }
}