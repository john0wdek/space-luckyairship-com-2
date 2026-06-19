<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $keyword;
    private array $styles;

    public function __construct(
        string $url,
        string $title,
        string $description,
        string $keyword,
        array $styles = []
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->keyword = $keyword;
        $this->styles = $styles;
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function buildInlineStyles(): string
    {
        $defaultStyles = [
            'display' => 'inline-block',
            'padding' => '16px 24px',
            'background' => '#f4f6f8',
            'border' => '1px solid #d0d7de',
            'borderRadius' => '8px',
            'textDecoration' => 'none',
            'color' => '#24292f',
            'fontFamily' => 'system-ui, sans-serif',
            'maxWidth' => '420px',
            'transition' => 'box-shadow 0.2s ease',
        ];

        $merged = array_merge($defaultStyles, $this->styles);
        $parts = [];
        foreach ($merged as $property => $value) {
            $cssProperty = ltrim(strtolower(preg_replace('/[A-Z]/', '-$0', $property)), '-');
            $parts[] = $cssProperty . ':' . $value;
        }
        return implode(';', $parts);
    }

    public function render(): string
    {
        $escapedUrl = $this->escape($this->url);
        $escapedTitle = $this->escape($this->title);
        $escapedDescription = $this->escape($this->description);
        $escapedKeyword = $this->escape($this->keyword);
        $inlineStyles = $this->buildInlineStyles();

        $html = '<a href="' . $escapedUrl . '" style="' . $inlineStyles . '" target="_blank" rel="noopener noreferrer">';
        $html .= '<div style="font-size:18px;font-weight:600;margin-bottom:6px;">' . $escapedTitle . '</div>';
        $html .= '<div style="font-size:14px;color:#57606a;margin-bottom:4px;">' . $escapedDescription . '</div>';
        $html .= '<span style="font-size:12px;color:#6e7781;">相关关键词：' . $escapedKeyword . '</span>';
        $html .= '</a>';

        return $html;
    }
}

function createDefaultLinkCard(): LinkCard
{
    return new LinkCard(
        url: 'https://space-luckyairship.com',
        title: '幸运飞艇',
        description: '探索幸运与速度的完美结合',
        keyword: '幸运飞艇',
        styles: [
            'boxShadow' => '0 2px 6px rgba(0,0,0,0.08)',
            'border' => '1px solid #e1e4e8',
        ]
    );
}

function renderLinkCardSample(): void
{
    $card = createDefaultLinkCard();
    echo $card->render();
}