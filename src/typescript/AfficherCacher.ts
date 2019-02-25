export class AfficherCacher extends HTMLElement {
    private template: HTMLTemplateElement;
    private bouton: HTMLButtonElement;
    private contenu: HTMLElement;

    public constructor(){
        super();
        this.template = document.createElement('template');
        this.template.innerHTML = `
            <button aria-expanded="false"><slot name="titre">Un titre</slot></button>
            <slot></slot>
            <style>
         button{
            border:none;
         } 
         button:hover, button:focus{
         background-color: #851139;
         transition: .5s ease-in;
         color: white;
         }
         button[aria-expanded="false"] ::slotted(p):before {
                content: "▼";
         }
         button[aria-expanded="true"]{
             background-color: #851139;  
         }
         button[aria-expanded="true"] ::slotted(p):before {
                content: "▲";    
         }
     }</style>`;

        this.attachShadow({mode:"open"})
            .appendChild(this.template.content.cloneNode(true));


        this.bouton = this.shadowRoot.querySelector('button');
        this.bouton.addEventListener('click', this.afficherCacher.bind(this));
        this.contenu = this.shadowRoot.querySelector('button').nextElementSibling;
        this.contenu.setAttribute('hidden', 'true');
    }
    afficherCacher() {
        if(this.bouton.getAttribute('aria-expanded') == 'true') {
            this.bouton.setAttribute('aria-expanded', 'false');
            this.contenu.setAttribute('hidden', 'true');
        }
        else {
            this.bouton.setAttribute('aria-expanded', 'true');
            this.contenu.removeAttribute('hidden');
        }
    }
}