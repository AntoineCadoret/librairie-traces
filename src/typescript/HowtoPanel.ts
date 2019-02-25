/**
 * `HowtoPanel` is a panel for a `<howto-tabs>` tab panel.
 */
export class HowtoPanel extends HTMLElement {

    static compteur:number = 0;

    constructor() {
        super();
    }

    connectedCallback() {
        this.setAttribute('role', 'tabpanel');
        if (!this.id)
            this.id = `howto-panel-generated-${HowtoPanel.compteur++}`;
    }
}