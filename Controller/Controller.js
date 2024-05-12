import { Autoloader } from '../../../jsOMS/Autoloader.js';
import { BrowserMultiFormatReader } from '../../../Resources/zxing/zxing.min.js';

Autoloader.defineNamespace('omsApp.Modules');

/* global omsApp */
omsApp.Modules.StockTaking = class {
    /**
     * @constructor
     *
     * @since 1.0.0
     */
    constructor (app)
    {
        this.scan = null;
        this.canvas = null;
        this.ctx = null;
        this.video = null;
        this.videoBtn = null;
        this.input = null;
        this.deviceId = null;
        this.data = '';
        this.codeReader = null;
        this.capabilities = null;
        this.settings = null;
        this.zoom = null;
        this.track = null;
    };

    bind (id)
    {
        const e = typeof id === 'undefined'
            ? [document.getElementById('iScanner')]
            : [document.getElementById(id)];

        const length = e.length;

        for (let i = 0; i < length; ++i) {
            this.bindElement(e[i]);
        }
    };

    bindElement (scan)
    {
        this.scan = scan;
        this.video = scan.getElementsByTagName('video')[0];
        this.input = document.getElementById('iScanData');
        this.canvas = scan.getElementsByTagName('canvas')[0];
        this.canvas.style.background = 'transparent';
        this.videoBtn = scan.getElementsByTagName('button')[0];
        this.ctx = this.canvas.getContext('2d', { willReadFrequently: true });
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.zoom = scan.querySelector('input[type=range]');
        this.data = '';

        const self = this;

        this.videoBtn.addEventListener('click', () => {
            if (!self.deviceId && 'mediaDevices' in navigator) {
                navigator.mediaDevices.getUserMedia({audio: false, video: {facingMode: 'environment'}})
                    .then(stream => {
                        self.codeReader = new BrowserMultiFormatReader();

                        self.detectVideo(true);

                        stream.getTracks().forEach(t => {
                            if (t.enabled && (t.kind === 'video' || t.kind === 'videoinput')) {
                                self.deviceId = t.id;
                                self.track = t;

                                self.capabilities = t.getCapabilities();
                                self.settings = t.getSettings();
                            }
                        });

                        if ("zoom" in self.settings) {
                            self.zoom.min = self.capabilities.zoom.min;
                            self.zoom.max = self.capabilities.zoom.max;
                            self.zoom.step = self.capabilities.zoom.step;
                            self.zoom.value = self.settings.zoom;

                            self.zoom.addEventListener("input", async () => {
                                await self.track.applyConstraints({ advanced: [{ zoom: self.input.value }] });
                            });
                        }
                    });
            } else {
                self.detectVideo(false);
            }
        });

        this.video.addEventListener('click', () => {
            self.input.value = self.data;
        });
    };

    detectVideo (repeat) {
        if (!repeat) {
            this.codeReader.reset();
            this.deviceId = null;

            return;
        }

        const self = this;
        this.codeReader.decodeFromVideoDevice(this.deviceId, this.video.id, (result, err) => {
            if (result) {
                self.data = result.text;
            }
        });
    };
};

window.omsApp.moduleManager.get('StockTaking').bind();
