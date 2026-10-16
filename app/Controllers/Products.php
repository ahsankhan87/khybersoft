<?php

namespace App\Controllers;

use App\Concerns\HandlesFormSubmissions;
use App\Models\ClientModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductFaqModel;
use App\Models\ProductFeatureModel;
use App\Models\ProductModel;
use App\Models\ProductPlanModel;
use App\Models\ProductScreenshotModel;
use App\Models\TestimonialModel;
use App\Models\TutorialModel;

/**
 * Public product pages: listing, category, detail (conversion page).
 */
class Products extends BaseController
{
    use HandlesFormSubmissions;

    /** A) /products — listing with pills, search, grid/list toggle. */
    public function index()
    {
        $q       = trim((string) $this->request->getVar('q'));
        $catSlug = trim((string) $this->request->getVar('category'));

        $categories = model(ProductCategoryModel::class)->active();
        $catId      = null;
        foreach ($categories as $c) {
            if ($c['slug'] === $catSlug) { $catId = (int) $c['id']; break; }
        }

        $products = model(ProductModel::class)->filter($catId, $q);
        $featured = array_values(array_filter($products, static fn ($p) => ! empty($p['is_featured'])));
        $rest     = array_values(array_filter($products, static fn ($p) => empty($p['is_featured'])));

        $data = [
            'title'            => 'Products — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => setting('products_list_meta', 'POS, Accounting, School Management, Plot Management and HR software. One platform for every business need.'),
            'heading'          => setting('products_list_heading', 'Software that powers your business'),
            'subheading'       => setting('products_list_subheading', 'Purpose-built modules that share one database, one login and one price. Start with what you need today, switch everything on when you grow.'),
            'categories'       => $categories,
            'activeCategory'   => $catSlug,
            'searchQuery'      => $q,
            'featured'         => $featured,
            'products'         => $rest,
            'faqs'             => json_decode(setting('products_page_faqs', '[]'), true) ?: [],
            'jsonLd'           => $this->breadcrumbLd([['Home', '/'], ['Products', '/products']]),
        ];

        return $this->renderPage('front/products/index', $data);
    }

    /** B) /products/category/{slug} */
    public function category(string $slug)
    {
        $cat = null;
        foreach (model(ProductCategoryModel::class)->active() as $c) {
            if ($c['slug'] === $slug) { $cat = $c; break; }
        }
        if (! $cat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $products = model(ProductModel::class)->filter((int) $cat['id']);

        // Category intro/FAQ: settings override, else stored on first product row of the category.
        $intro = setting('category_intro_' . $slug) ?: ($products[0]['category_intro'] ?? null);
        $faq   = json_decode(setting('category_faq_' . $slug, '[]'), true)
                 ?: json_decode((string) ($products[0]['category_faq'] ?? '[]'), true) ?: [];

        $trail = [['Home', '/'], ['Products', '/products'], [$cat['name'], '/products/category/' . $slug]];

        $data = [
            'title'            => $cat['name'] . ' Software — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => mb_substr(strip_tags((string) $intro), 0, 160) ?: setting('site_description'),
            'category'         => $cat,
            'intro'            => $intro,
            'products'         => $products,
            'testimonials'     => model(TestimonialModel::class)->forIndustry($cat['name'], 2),
            'faqs'             => $faq,
            'breadcrumbs'      => $trail,
            'jsonLd'           => $this->breadcrumbLd($trail),
        ];

        return $this->renderPage('front/products/category', $data);
    }

    /** C) /products/{slug} — the conversion page. */
    public function show(string $slug)
    {
        $product = model(ProductModel::class)->bySlug($slug);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $pid = (int) $product['id'];

        $plans       = model(ProductPlanModel::class)->forProduct($pid);
        $features    = model(ProductFeatureModel::class)->grid($pid, 8);
        $tabs        = model(ProductFeatureModel::class)->deepDiveTabs($pid);
        $screenshots = model(ProductScreenshotModel::class)->forProduct($pid);
        $faqs        = model(ProductFaqModel::class)->forProduct($pid);
        $tutorials   = model(TutorialModel::class)->active(3, $pid) ?: model(TutorialModel::class)->active(3);

        $category = null;
        if ($product['category_id']) {
            foreach (model(ProductCategoryModel::class)->active() as $c) {
                if ((int) $c['id'] === (int) $product['category_id']) { $category = $c; break; }
            }
        }

        $trail = [['Home', '/'], ['Products', '/products'], [$product['name'], '/products/' . $slug]];

        $data = [
            'title'            => $product['seo_title'] ?: ($product['name'] . ' — ' . setting('site_name', 'Khybersoft')),
            'meta_description' => $product['seo_description'] ?: mb_substr(strip_tags((string) ($product['tagline'] ?: $product['description'])), 0, 160),
            'og_image'         => $product['og_image'] ?: $product['hero_image'],
            'canonical'        => $product['canonical_url'] ?: site_url_path('/products/' . $product['slug']),
            'product'          => $product,
            'category'         => $category,
            'plans'            => $plans,
            'features'         => $features,
            'deepDiveTabs'     => $tabs,
            'screenshots'      => $screenshots,
            'faqs'             => $faqs,
            'tutorials'        => $tutorials,
            'testimonials'     => model(TestimonialModel::class)->forProduct($pid, 3),
            'trustClients'     => model(ClientModel::class)->forIndustry($category['name'] ?? null, 8),
            'related'          => model(ProductModel::class)->related($product, 3),
            'breadcrumbs'      => $trail,
            'jsonLd'           => array_merge(
                $this->productSchema($product, $plans, $faqs),
                [$this->bcItem($trail)]
            ),
        ];

        return $this->renderPage('front/products/show', $data);
    }

    /** Lead capture from product CTAs (Book Demo / Get Quote tabs). */
    public function leadRequest()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/products');
        }

        if (! $this->throttle('product-lead', 4, 3600)) {
            return redirect()->back()->with('error', 'Too many requests — please try again in an hour.')->withInput();
        }

        $rules = [
            'name'    => 'required|min_length[2]|max_length[200]',
            'email'   => 'required|max_length[255]|valid_email',
            'message' => 'permit_empty|max_length[3000]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $productId = (int) $this->request->getPost('product_id');
        $type      = $this->request->getPost('lead_type') === 'quote' ? 'quote' : 'demo';
        $prodName  = $productId ? (model(ProductModel::class)->find($productId)['name'] ?? 'Product') : 'General';

        $this->recordLead($type, [
            'name'       => (string) $this->request->getPost('name'),
            'company'    => (string) $this->request->getPost('company'),
            'email'      => strtolower(trim((string) $this->request->getPost('email'))),
            'phone'      => (string) $this->request->getPost('phone'),
            'subject'    => '[' . ($type === 'quote' ? 'Quote' : 'Demo') . '] ' . $prodName,
            'message'    => (string) $this->request->getPost('message'),
            'product_id' => $productId ?: null,
            'plan_id'    => (int) $this->request->getPost('plan_id') ?: null,
        ]);

        $this->notifyAdmins('New product ' . $type . ' request — ' . $prodName, '<p>A visitor requested a ' . $type . ' for <strong>' . esc($prodName) . '</strong>. Review it in Admin → Leads.</p>');

        return redirect()->back()->with('success', 'Thanks! Our team will contact you within one business day.');
    }

    // ------------------------------------------------------------------ schemas

    private function productSchema(array $p, array $plans, array $faqs): array
    {
        $offers = [];
        foreach ($plans as $plan) {
            if ($plan['price_monthly'] === null && $plan['price_yearly'] === null) {
                continue;
            }
            $offers[] = [
                '@type'         => 'Offer',
                'name'          => $p['name'] . ' ' . $plan['name'],
                'price'         => (float) ($plan['price_monthly'] ?: $plan['price_yearly']),
                'priceCurrency' => $plan['currency'] ?: 'PKR',
                'url'           => site_url_path('/products/' . $p['slug']),
                'availability'  => 'https://schema.org/InStock',
            ];
        }

        $ld = [[
            '@context'            => 'https://schema.org',
            '@type'               => 'SoftwareApplication',
            'name'                => $p['name'],
            'description'         => mb_substr(strip_tags((string) ($p['description'] ?: $p['tagline'])), 0, 300),
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem'     => 'Web, Windows, Android, iOS',
            'url'                 => site_url_path('/products/' . $p['slug']),
            'offers'              => $offers ?: [[
                '@type' => 'Offer', 'name' => 'Free trial', 'price' => 0,
                'priceCurrency' => 'PKR', 'url' => site_url_path('/products/' . $p['slug']),
            ]],
            'aggregateRating' => [
                '@type'       => 'AggregateRating',
                'ratingValue' => (string) ($p['rating_avg'] ?: '4.9'),
                'reviewCount' => (string) max(1, (int) ($p['rating_count'] ?: 200)),
            ],
        ]];

        if ($faqs) {
            $ld[] = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => array_map(static fn ($f) => [
                    '@type'          => 'Question',
                    'name'           => $f['question'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags((string) $f['answer'])],
                ], $faqs),
            ];
        }

        return $ld;
    }

    private function bcItem(array $trail): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => array_map(static fn ($t, $i) => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $t[0],
                'item'     => site_url_path($t[1]),
            ], $trail, array_keys($trail)),
        ];
    }

    private function breadcrumbLd(array $trail): array
    {
        return [$this->bcItem($trail)];
    }
}
