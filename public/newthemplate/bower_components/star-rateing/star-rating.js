;(function ($) {

    jQuery.fn.starsRateing = function (options) {

        let Rate = new Rateing(this, options);
        Rate.RenderStars();
        Rate.addActions();
        Rate.showRateing();

        return Rate;

    };

    function Rateing(el, options) {

        let Default = {
            rateStep: 0.25,
            width: 20,
            heigth: 20,
            disabled:false,
            rate: 0,
            stroke: "",
            color:"#f7f6fa",
            ratedColor:"#fdd835",
            starcount: 5,
            showRate: false,
            onRate:function (rate) {

            },
            rateThemplate:(data)=>{
                return `<span class="rate-num">${(Math.round(data.rate*100)/100).toFixed(2)}</span>`;
            },
            starThemplate: (data) => {
                return `<svg xmlns="http://www.w3.org/2000/svg" width="${data.width}" height="${data.height}" viewBox="0 0 51 48">
                            <path fill="${data.fill}" stroke="${data.stroke}" d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                        </svg>`;
            },
        };

        let starsOver;
        let Rate = this;

        options = $.extend({}, Default, options);

        function getOverlines(c) {

            let lines = "";

            for(let i=1;i<=c;i++){
                let style = `width:${(100/c)*i}%;z-index:${(c-i)+99};height:100%;position:absolute`;
                lines += `<span data-width="${(100/c)*i}" style="${style}"></span>`
            }

            return lines

        }

        function setStarRate(star,width) {

            let starover = star.find('.starover').width(width+"%");
            let prev = star.prev();

            if(prev.length > 0){
                setStarRate(prev,100)
            }

        }
        
        function hoverLineAction() {

            let that = $(this);
            let star = that.parents('.star');
            starsOver.width("0%");
            setStarRate(star,parseFloat(that.data('width')));

            if(options.showRate){
                let starRate = getRating(this);
                el.find('.showrate').html(options.rateThemplate({rate:starRate}));
            }
        }

        function getRating(hoverel) {

            if(hoverel){

                let that = $(hoverel);
                let star = that.parents('.star');
                let starRate = parseFloat(star.data('rate'));
                let rate = parseFloat(hoverel.dataset.width);
                starRate = isNaN(starRate) ? 0 : starRate;
                rate = isNaN(rate) ? 0 : rate;
                return starRate + (rate/100);

            }

            return 0;

        }

        function clickLineAction() {

            /*let that = $(this);
            let star = that.parents('.star');
            let starRate = parseFloat(star.data('rate'));
            let rate = parseFloat(this.dataset.width);
            starRate = isNaN(starRate) ? 0 : starRate;
            rate = isNaN(rate) ? 0 : rate; */
            let starRate = getRating(this);
            options.onRate.apply(el.get(0),[starRate]);
            Rate.setRateing(starRate);

        }

        this.RenderStars = function () {

            let html  = "";
            let lines = 1/options.rateStep;

            for (let i = 0; i < options.starcount; i++) {

                html += `
                           <div data-rate="${i}" class="star" style="width:${options.width}px;height:${options.heigth}px;">
                                <div class="starline">
                                    ${options.starThemplate({
                                        width:options.width,
                                        height:options.heigth,
                                        stroke:options.stroke,
                                        fill:options.color,
                                    })}
                               </div>
                               <div class="starover">
                                    ${options.starThemplate({
                                        width:options.width,
                                        height:options.heigth,
                                        stroke:options.stroke,
                                        fill:options.ratedColor,
                                    })}
                               </div>
                               <div class="overLines">
                                ${getOverlines(lines)}
                               </div>
                           </div>
                            
                        `;

            }

            html = !options.showRate ? `<div class="stars-all ${options.disabled ? "disabled" : ""}">
                                            ${html}
                                        </div>` :
                                        `
                                        <div class="showrate">
                                            ${options.rateThemplate({rate:options.rate})}
                                        </div>
                                        <div class="stars-all">
                                            ${html}
                                         </div>`;



            el.html(html);
            starsOver = el.find('.starover');
        };

        this.addActions = function () {

            el.find('.overLines span').bind('mouseover',hoverLineAction)
                .bind('click',clickLineAction);
            el.bind('mouseleave',function () {
                this.showRateing();
            }.bind(this));

        };

        this.showRateing = function () {

            starsOver.width("0%");
            let star   = Math.ceil(options.rate);
            let rate   = options.rate - Math.floor(options.rate);
            let $star  = el.find('.star:eq('+(star > 0 ? star-1 : 0)+')');
            rate = rate > 0 ? rate*100 : (star > 0 ? 100 : 0);
            setStarRate($star,rate);

            if(options.showRate){
                el.find('.showrate').html(options.rateThemplate({rate:options.rate}));
            }

        };

        this.setRateing = function (rate) {

            options.rate = rate;
            this.showRateing();

        }

    }


})(jQuery);