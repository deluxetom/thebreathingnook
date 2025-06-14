import { Controller } from '@hotwired/stimulus';
import {useClickOutside, useTransition} from 'stimulus-use';

export default class extends Controller {
    static targets = ['hamburger', 'menu'];

    connect() {
        useClickOutside(this);
        useTransition(this, {
            element: this.menuTarget,
            enterActive: 'transition ease-out duration-300',
            enterFrom: 'transform -translate-x-1/2',
            enterTo: 'transform translate-x-0',
            leaveActive: 'transition ease-out duration-300',
            leaveFrom: 'transform translate-x-0',
            leaveTo: 'transform -translate-x-full',
        });
    }

    close() {
        this.leave();
        document.body.style.overflowY = 'visible';
    }

    open() {
        this.enter();
        document.body.style.overflowY = 'hidden';
    }

    toggle() {
        if (this.transitioned) {
            this.close();
        } else {
            this.open();
        }
    }

    clickOutside() {
        this.close();
    }
}
