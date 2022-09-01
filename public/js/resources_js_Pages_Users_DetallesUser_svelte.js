"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Users_DetallesUser_svelte"],{

/***/ "./resources/js/Pages/Users/DetallesUser.svelte":
/*!******************************************************!*\
  !*** ./resources/js/Pages/Users/DetallesUser.svelte ***!
  \******************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var svelte_internal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! svelte/internal */ "./node_modules/svelte/internal/index.mjs");
/* harmony import */ var C_xampp_htdocs_rredsi_ibis_node_modules_svelte_loader_lib_hot_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./node_modules/svelte-loader/lib/hot-api.js */ "./node_modules/svelte-loader/lib/hot-api.js");
/* harmony import */ var C_xampp_htdocs_rredsi_ibis_node_modules_svelte_hmr_runtime_proxy_adapter_dom_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/svelte-hmr/runtime/proxy-adapter-dom.js */ "./node_modules/svelte-hmr/runtime/proxy-adapter-dom.js");
/* module decorator */ module = __webpack_require__.hmd(module);
/* resources\js\Pages\Users\DetallesUser.svelte generated by Svelte v3.46.4 */


function get_each_context(ctx, list, i) {
	const child_ctx = ctx.slice();
	child_ctx[1] = list[i];
	return child_ctx;
}

function get_each_context_1(ctx, list, i) {
	const child_ctx = ctx.slice();
	child_ctx[4] = list[i];
	return child_ctx;
}

function get_each_context_2(ctx, list, i) {
	const child_ctx = ctx.slice();
	child_ctx[7] = list[i];
	return child_ctx;
}

function get_each_context_3(ctx, list, i) {
	const child_ctx = ctx.slice();
	child_ctx[10] = list[i];
	return child_ctx;
}

// (8:4) {#if user.institucion_educativa}
function create_if_block_6(ctx) {
	let p0;
	let t1;
	let div;
	let figure;
	let img;
	let img_src_value;
	let img_alt_value;
	let t2;
	let p1;
	let t3_value = /*user*/ ctx[0].institucion_educativa.nombre + "";
	let t3;
	let t4;
	let hr;

	return {
		c() {
			p0 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p0.textContent = "Institución educativa";
			t1 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			figure = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("figure");
			img = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("img");
			t2 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			p1 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			t3 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t3_value);
			t4 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			hr = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("hr");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p0, "class", "font-medium mt-4");
			if (!(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.src_url_equal)(img.src, img_src_value = "/storage/" + /*user*/ ctx[0].institucion_educativa.logo)) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(img, "src", img_src_value);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(img, "class", "h-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(img, "alt", img_alt_value = "Logo " + /*user*/ ctx[0].institucion_educativa.nombre);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(figure, "class", "mr-2");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div, "class", "flex items-center mt-2");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(hr, "class", "block my-20");
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, p0, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, t1, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, div, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div, figure);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(figure, img);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div, t2);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div, p1);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(p1, t3);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, t4, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, hr, anchor);
		},
		p(ctx, dirty) {
			if (dirty & /*user*/ 1 && !(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.src_url_equal)(img.src, img_src_value = "/storage/" + /*user*/ ctx[0].institucion_educativa.logo)) {
				(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(img, "src", img_src_value);
			}

			if (dirty & /*user*/ 1 && img_alt_value !== (img_alt_value = "Logo " + /*user*/ ctx[0].institucion_educativa.nombre)) {
				(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(img, "alt", img_alt_value);
			}

			if (dirty & /*user*/ 1 && t3_value !== (t3_value = /*user*/ ctx[0].institucion_educativa.nombre + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t3, t3_value);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(p0);
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(t1);
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(div);
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(t4);
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(hr);
		}
	};
}

// (52:16) {:else}
function create_else_block_2(ctx) {
	let p;

	return {
		c() {
			p = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p.textContent = "Sin información registrada.";
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, p, anchor);
		},
		p: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(p);
		}
	};
}

// (44:16) {#if user.intereses}
function create_if_block_5(ctx) {
	let ul;
	let each_value_3 = JSON.parse(/*user*/ ctx[0].intereses);
	let each_blocks = [];

	for (let i = 0; i < each_value_3.length; i += 1) {
		each_blocks[i] = create_each_block_3(get_each_context_3(ctx, each_value_3, i));
	}

	return {
		c() {
			ul = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("ul");

			for (let i = 0; i < each_blocks.length; i += 1) {
				each_blocks[i].c();
			}
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, ul, anchor);

			for (let i = 0; i < each_blocks.length; i += 1) {
				each_blocks[i].m(ul, null);
			}
		},
		p(ctx, dirty) {
			if (dirty & /*JSON, user*/ 1) {
				each_value_3 = JSON.parse(/*user*/ ctx[0].intereses);
				let i;

				for (i = 0; i < each_value_3.length; i += 1) {
					const child_ctx = get_each_context_3(ctx, each_value_3, i);

					if (each_blocks[i]) {
						each_blocks[i].p(child_ctx, dirty);
					} else {
						each_blocks[i] = create_each_block_3(child_ctx);
						each_blocks[i].c();
						each_blocks[i].m(ul, null);
					}
				}

				for (; i < each_blocks.length; i += 1) {
					each_blocks[i].d(1);
				}

				each_blocks.length = each_value_3.length;
			}
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(ul);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.destroy_each)(each_blocks, detaching);
		}
	};
}

// (46:24) {#each JSON.parse(user.intereses) as interes}
function create_each_block_3(ctx) {
	let li;
	let t0_value = /*interes*/ ctx[10].value + "";
	let t0;
	let t1;

	return {
		c() {
			li = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("li");
			t0 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t0_value);
			t1 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, li, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t0);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t1);
		},
		p(ctx, dirty) {
			if (dirty & /*user*/ 1 && t0_value !== (t0_value = /*interes*/ ctx[10].value + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t0, t0_value);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(li);
		}
	};
}

// (61:16) {:else}
function create_else_block_1(ctx) {
	let p;

	return {
		c() {
			p = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p.textContent = "Sin información registrada.";
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, p, anchor);
		},
		p: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(p);
		}
	};
}

// (59:16) {#if user.cvlac}
function create_if_block_4(ctx) {
	let a;
	let t;
	let a_href_value;

	return {
		c() {
			a = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("a");
			t = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)("Ver CvLAC");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "href", a_href_value = /*user*/ ctx[0].cvlac);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "target", "_blank");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "class", "underline");
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, a, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(a, t);
		},
		p(ctx, dirty) {
			if (dirty & /*user*/ 1 && a_href_value !== (a_href_value = /*user*/ ctx[0].cvlac)) {
				(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "href", a_href_value);
			}
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(a);
		}
	};
}

// (70:16) {:else}
function create_else_block(ctx) {
	let p;

	return {
		c() {
			p = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p.textContent = "Sin información registrada.";
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, p, anchor);
		},
		p: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(p);
		}
	};
}

// (68:16) {#if user.cv}
function create_if_block_3(ctx) {
	let a;
	let t;
	let a_href_value;

	return {
		c() {
			a = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("a");
			t = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)("Ver hoja de vida");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "href", a_href_value = '/storage/' + /*user*/ ctx[0].cv);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "target", "_blank");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "class", "underline");
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, a, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(a, t);
		},
		p(ctx, dirty) {
			if (dirty & /*user*/ 1 && a_href_value !== (a_href_value = '/storage/' + /*user*/ ctx[0].cv)) {
				(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "href", a_href_value);
			}
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(a);
		}
	};
}

// (78:20) {#each user.estudios as estudio}
function create_each_block_2(ctx) {
	let li;
	let t0;
	let t1_value = /*estudio*/ ctx[7].programa_academico + "";
	let t1;
	let t2;
	let br;
	let t3;
	let span;
	let t4;
	let t5_value = /*estudio*/ ctx[7].institucion_educativa + "";
	let t5;

	return {
		c() {
			li = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("li");
			t0 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)("Programa académico: ");
			t1 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t1_value);
			t2 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			br = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("br");
			t3 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			span = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("span");
			t4 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)("Institución educativa: ");
			t5 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t5_value);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(span, "class", "text-xs");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(li, "class", "mb-4");
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, li, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t0);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t1);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t2);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, br);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t3);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, span);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(span, t4);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(span, t5);
		},
		p(ctx, dirty) {
			if (dirty & /*user*/ 1 && t1_value !== (t1_value = /*estudio*/ ctx[7].programa_academico + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t1, t1_value);
			if (dirty & /*user*/ 1 && t5_value !== (t5_value = /*estudio*/ ctx[7].institucion_educativa + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t5, t5_value);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(li);
		}
	};
}

// (85:20) {#if user.estudios.length == 0}
function create_if_block_2(ctx) {
	let li;

	return {
		c() {
			li = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("li");
			li.textContent = "Sin información registrada.";
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, li, anchor);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(li);
		}
	};
}

// (94:20) {#each user.semilleros_investigacion as semillero_investigacion}
function create_each_block_1(ctx) {
	let li;
	let t_value = /*semillero_investigacion*/ ctx[4].nombre + "";
	let t;

	return {
		c() {
			li = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("li");
			t = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t_value);
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, li, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t);
		},
		p(ctx, dirty) {
			if (dirty & /*user*/ 1 && t_value !== (t_value = /*semillero_investigacion*/ ctx[4].nombre + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t, t_value);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(li);
		}
	};
}

// (97:20) {#if user.semilleros_investigacion.length == 0}
function create_if_block_1(ctx) {
	let li;

	return {
		c() {
			li = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("li");
			li.textContent = "Sin información registrada.";
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, li, anchor);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(li);
		}
	};
}

// (106:20) {#each user.proyectos as proyecto}
function create_each_block(ctx) {
	let li;
	let t_value = /*proyecto*/ ctx[1].titulo + "";
	let t;

	return {
		c() {
			li = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("li");
			t = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t_value);
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, li, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(li, t);
		},
		p(ctx, dirty) {
			if (dirty & /*user*/ 1 && t_value !== (t_value = /*proyecto*/ ctx[1].titulo + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t, t_value);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(li);
		}
	};
}

// (109:20) {#if user.proyectos.length == 0}
function create_if_block(ctx) {
	let li;

	return {
		c() {
			li = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("li");
			li.textContent = "Sin información registrada.";
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, li, anchor);
		},
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(li);
		}
	};
}

function create_fragment(ctx) {
	let h10;
	let t0_value = /*user*/ ctx[0].name + "";
	let t0;
	let t1;
	let div11;
	let t2;
	let h11;
	let t4;
	let p0;

	let t5_value = (/*user*/ ctx[0].perfil
	? /*user*/ ctx[0].perfil
	: 'Sin información registrada.') + "";

	let t5;
	let t6;
	let hr;
	let t7;
	let div10;
	let div0;
	let t11;
	let div9;
	let div1;
	let p2;
	let t13;
	let a;
	let t14_value = /*user*/ ctx[0].email + "";
	let t14;
	let a_href_value;
	let t15;
	let div2;
	let p3;
	let t17;
	let p4;
	let t18_value = /*user*/ ctx[0].numero_celular + "";
	let t18;
	let t19;
	let div3;
	let p5;
	let t21;
	let t22;
	let div4;
	let p6;
	let t24;
	let t25;
	let div5;
	let p7;
	let t27;
	let t28;
	let div6;
	let p8;
	let t30;
	let ul0;
	let t31;
	let t32;
	let div7;
	let p9;
	let t34;
	let ul1;
	let t35;
	let t36;
	let div8;
	let p10;
	let t38;
	let ul2;
	let t39;
	let if_block0 = /*user*/ ctx[0].institucion_educativa && create_if_block_6(ctx);

	function select_block_type(ctx, dirty) {
		if (/*user*/ ctx[0].intereses) return create_if_block_5;
		return create_else_block_2;
	}

	let current_block_type = select_block_type(ctx, -1);
	let if_block1 = current_block_type(ctx);

	function select_block_type_1(ctx, dirty) {
		if (/*user*/ ctx[0].cvlac) return create_if_block_4;
		return create_else_block_1;
	}

	let current_block_type_1 = select_block_type_1(ctx, -1);
	let if_block2 = current_block_type_1(ctx);

	function select_block_type_2(ctx, dirty) {
		if (/*user*/ ctx[0].cv) return create_if_block_3;
		return create_else_block;
	}

	let current_block_type_2 = select_block_type_2(ctx, -1);
	let if_block3 = current_block_type_2(ctx);
	let each_value_2 = /*user*/ ctx[0].estudios;
	let each_blocks_2 = [];

	for (let i = 0; i < each_value_2.length; i += 1) {
		each_blocks_2[i] = create_each_block_2(get_each_context_2(ctx, each_value_2, i));
	}

	let if_block4 = /*user*/ ctx[0].estudios.length == 0 && create_if_block_2(ctx);
	let each_value_1 = /*user*/ ctx[0].semilleros_investigacion;
	let each_blocks_1 = [];

	for (let i = 0; i < each_value_1.length; i += 1) {
		each_blocks_1[i] = create_each_block_1(get_each_context_1(ctx, each_value_1, i));
	}

	let if_block5 = /*user*/ ctx[0].semilleros_investigacion.length == 0 && create_if_block_1(ctx);
	let each_value = /*user*/ ctx[0].proyectos;
	let each_blocks = [];

	for (let i = 0; i < each_value.length; i += 1) {
		each_blocks[i] = create_each_block(get_each_context(ctx, each_value, i));
	}

	let if_block6 = /*user*/ ctx[0].proyectos.length == 0 && create_if_block(ctx);

	return {
		c() {
			h10 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("h1");
			t0 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t0_value);
			t1 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div11 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			if (if_block0) if_block0.c();
			t2 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			h11 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("h1");
			h11.textContent = "Perfil";
			t4 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			p0 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			t5 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t5_value);
			t6 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			hr = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("hr");
			t7 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div10 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			div0 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");

			div0.innerHTML = `<h1 class="font-medium">Información</h1> 
            <p class="mt-1 text-sm text-gray-600">Revise la información del usuario.</p>`;

			t11 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div9 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			div1 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p2 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p2.textContent = "Correo electrónico";
			t13 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			a = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("a");
			t14 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t14_value);
			t15 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div2 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p3 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p3.textContent = "Número de celular";
			t17 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			p4 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			t18 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.text)(t18_value);
			t19 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div3 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p5 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p5.textContent = "Intereses profesionales y formativos";
			t21 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			if_block1.c();
			t22 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div4 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p6 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p6.textContent = "CvLAC";
			t24 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			if_block2.c();
			t25 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div5 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p7 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p7.textContent = "Hoja de vida";
			t27 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			if_block3.c();
			t28 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div6 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p8 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p8.textContent = "Estudios";
			t30 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			ul0 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("ul");

			for (let i = 0; i < each_blocks_2.length; i += 1) {
				each_blocks_2[i].c();
			}

			t31 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			if (if_block4) if_block4.c();
			t32 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div7 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p9 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p9.textContent = "Semilleros de investigación asociados";
			t34 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			ul1 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("ul");

			for (let i = 0; i < each_blocks_1.length; i += 1) {
				each_blocks_1[i].c();
			}

			t35 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			if (if_block5) if_block5.c();
			t36 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			div8 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
			p10 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
			p10.textContent = "Proyectos asociados";
			t38 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			ul2 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("ul");

			for (let i = 0; i < each_blocks.length; i += 1) {
				each_blocks[i].c();
			}

			t39 = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.space)();
			if (if_block6) if_block6.c();
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(h10, "class", "mt-10 text-3xl font-medium text-center");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(h11, "class", "text-2xl mt-20 mb-5");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p0, "class", "whitespace-pre-line text-justify");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(hr, "class", "block my-20");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p2, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "href", a_href_value = "mailto:" + /*user*/ ctx[0].email);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div1, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p3, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div2, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p5, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div3, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p6, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div4, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p7, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div5, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p8, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div6, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p9, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div7, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(p10, "class", "font-medium");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div8, "class", "py-8");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div9, "class", "bg-white rounded shadow p-8 divide-y");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div10, "class", "grid grid-cols-2 gap-3 mt-20");
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(div11, "class", "mb-20");
		},
		m(target, anchor) {
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, h10, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(h10, t0);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, t1, anchor);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert)(target, div11, anchor);
			if (if_block0) if_block0.m(div11, null);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, t2);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, h11);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, t4);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, p0);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(p0, t5);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, t6);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, hr);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, t7);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div11, div10);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div10, div0);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div10, t11);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div10, div9);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div1);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div1, p2);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div1, t13);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div1, a);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(a, t14);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, t15);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div2);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div2, p3);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div2, t17);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div2, p4);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(p4, t18);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, t19);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div3);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div3, p5);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div3, t21);
			if_block1.m(div3, null);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, t22);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div4);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div4, p6);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div4, t24);
			if_block2.m(div4, null);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, t25);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div5);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div5, p7);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div5, t27);
			if_block3.m(div5, null);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, t28);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div6);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div6, p8);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div6, t30);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div6, ul0);

			for (let i = 0; i < each_blocks_2.length; i += 1) {
				each_blocks_2[i].m(ul0, null);
			}

			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(ul0, t31);
			if (if_block4) if_block4.m(ul0, null);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, t32);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div7);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div7, p9);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div7, t34);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div7, ul1);

			for (let i = 0; i < each_blocks_1.length; i += 1) {
				each_blocks_1[i].m(ul1, null);
			}

			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(ul1, t35);
			if (if_block5) if_block5.m(ul1, null);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, t36);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div9, div8);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div8, p10);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div8, t38);
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(div8, ul2);

			for (let i = 0; i < each_blocks.length; i += 1) {
				each_blocks[i].m(ul2, null);
			}

			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append)(ul2, t39);
			if (if_block6) if_block6.m(ul2, null);
		},
		p(ctx, [dirty]) {
			if (dirty & /*user*/ 1 && t0_value !== (t0_value = /*user*/ ctx[0].name + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t0, t0_value);

			if (/*user*/ ctx[0].institucion_educativa) {
				if (if_block0) {
					if_block0.p(ctx, dirty);
				} else {
					if_block0 = create_if_block_6(ctx);
					if_block0.c();
					if_block0.m(div11, t2);
				}
			} else if (if_block0) {
				if_block0.d(1);
				if_block0 = null;
			}

			if (dirty & /*user*/ 1 && t5_value !== (t5_value = (/*user*/ ctx[0].perfil
			? /*user*/ ctx[0].perfil
			: 'Sin información registrada.') + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t5, t5_value);

			if (dirty & /*user*/ 1 && t14_value !== (t14_value = /*user*/ ctx[0].email + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t14, t14_value);

			if (dirty & /*user*/ 1 && a_href_value !== (a_href_value = "mailto:" + /*user*/ ctx[0].email)) {
				(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr)(a, "href", a_href_value);
			}

			if (dirty & /*user*/ 1 && t18_value !== (t18_value = /*user*/ ctx[0].numero_celular + "")) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.set_data)(t18, t18_value);

			if (current_block_type === (current_block_type = select_block_type(ctx, dirty)) && if_block1) {
				if_block1.p(ctx, dirty);
			} else {
				if_block1.d(1);
				if_block1 = current_block_type(ctx);

				if (if_block1) {
					if_block1.c();
					if_block1.m(div3, null);
				}
			}

			if (current_block_type_1 === (current_block_type_1 = select_block_type_1(ctx, dirty)) && if_block2) {
				if_block2.p(ctx, dirty);
			} else {
				if_block2.d(1);
				if_block2 = current_block_type_1(ctx);

				if (if_block2) {
					if_block2.c();
					if_block2.m(div4, null);
				}
			}

			if (current_block_type_2 === (current_block_type_2 = select_block_type_2(ctx, dirty)) && if_block3) {
				if_block3.p(ctx, dirty);
			} else {
				if_block3.d(1);
				if_block3 = current_block_type_2(ctx);

				if (if_block3) {
					if_block3.c();
					if_block3.m(div5, null);
				}
			}

			if (dirty & /*user*/ 1) {
				each_value_2 = /*user*/ ctx[0].estudios;
				let i;

				for (i = 0; i < each_value_2.length; i += 1) {
					const child_ctx = get_each_context_2(ctx, each_value_2, i);

					if (each_blocks_2[i]) {
						each_blocks_2[i].p(child_ctx, dirty);
					} else {
						each_blocks_2[i] = create_each_block_2(child_ctx);
						each_blocks_2[i].c();
						each_blocks_2[i].m(ul0, t31);
					}
				}

				for (; i < each_blocks_2.length; i += 1) {
					each_blocks_2[i].d(1);
				}

				each_blocks_2.length = each_value_2.length;
			}

			if (/*user*/ ctx[0].estudios.length == 0) {
				if (if_block4) {
					
				} else {
					if_block4 = create_if_block_2(ctx);
					if_block4.c();
					if_block4.m(ul0, null);
				}
			} else if (if_block4) {
				if_block4.d(1);
				if_block4 = null;
			}

			if (dirty & /*user*/ 1) {
				each_value_1 = /*user*/ ctx[0].semilleros_investigacion;
				let i;

				for (i = 0; i < each_value_1.length; i += 1) {
					const child_ctx = get_each_context_1(ctx, each_value_1, i);

					if (each_blocks_1[i]) {
						each_blocks_1[i].p(child_ctx, dirty);
					} else {
						each_blocks_1[i] = create_each_block_1(child_ctx);
						each_blocks_1[i].c();
						each_blocks_1[i].m(ul1, t35);
					}
				}

				for (; i < each_blocks_1.length; i += 1) {
					each_blocks_1[i].d(1);
				}

				each_blocks_1.length = each_value_1.length;
			}

			if (/*user*/ ctx[0].semilleros_investigacion.length == 0) {
				if (if_block5) {
					
				} else {
					if_block5 = create_if_block_1(ctx);
					if_block5.c();
					if_block5.m(ul1, null);
				}
			} else if (if_block5) {
				if_block5.d(1);
				if_block5 = null;
			}

			if (dirty & /*user*/ 1) {
				each_value = /*user*/ ctx[0].proyectos;
				let i;

				for (i = 0; i < each_value.length; i += 1) {
					const child_ctx = get_each_context(ctx, each_value, i);

					if (each_blocks[i]) {
						each_blocks[i].p(child_ctx, dirty);
					} else {
						each_blocks[i] = create_each_block(child_ctx);
						each_blocks[i].c();
						each_blocks[i].m(ul2, t39);
					}
				}

				for (; i < each_blocks.length; i += 1) {
					each_blocks[i].d(1);
				}

				each_blocks.length = each_value.length;
			}

			if (/*user*/ ctx[0].proyectos.length == 0) {
				if (if_block6) {
					
				} else {
					if_block6 = create_if_block(ctx);
					if_block6.c();
					if_block6.m(ul2, null);
				}
			} else if (if_block6) {
				if_block6.d(1);
				if_block6 = null;
			}
		},
		i: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
		o: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
		d(detaching) {
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(h10);
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(t1);
			if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach)(div11);
			if (if_block0) if_block0.d();
			if_block1.d();
			if_block2.d();
			if_block3.d();
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.destroy_each)(each_blocks_2, detaching);
			if (if_block4) if_block4.d();
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.destroy_each)(each_blocks_1, detaching);
			if (if_block5) if_block5.d();
			(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.destroy_each)(each_blocks, detaching);
			if (if_block6) if_block6.d();
		}
	};
}

function instance($$self, $$props, $$invalidate) {
	let { user } = $$props;

	$$self.$$set = $$props => {
		if ('user' in $$props) $$invalidate(0, user = $$props.user);
	};

	return [user];
}

class DetallesUser extends svelte_internal__WEBPACK_IMPORTED_MODULE_0__.SvelteComponent {
	constructor(options) {
		super();
		(0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.init)(this, options, instance, create_fragment, svelte_internal__WEBPACK_IMPORTED_MODULE_0__.safe_not_equal, { user: 0 });
	}
}

if (module && module.hot) {}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (DetallesUser);



/***/ })

}]);