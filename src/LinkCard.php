<?php

class LinkCard
{
    private string $title;
    private string $url;
    private string $description;
    private array $tags;
    private array $metadata;

    public function __construct(
        string $title = '爱游戏',
        string $url = 'https://i-game-home.com.cn',
        string $description = '探索精彩游戏世界',
        array $tags = ['游戏', '娱乐', '社区'],
        array $metadata = []
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->tags = $tags;
        $this->metadata = $metadata;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function addTag(string $tag): void
    {
        $this->tags[] = $tag;
    }

    public function setMetadata(array $metadata): void
    {
        $this->metadata = $metadata;
    }

    private function escapeHtml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public function render(): string
    {
        $escapedTitle = $this->escapeHtml($this->title);
        $escapedUrl = $this->escapeHtml($this->url);
        $escapedDescription = $this->escapeHtml($this->description);

        $tagHtml = '';
        if (!empty($this->tags)) {
            $tagParts = [];
            foreach ($this->tags as $tag) {
                $escapedTag = $this->escapeHtml($tag);
                $tagParts[] = '<span class="link-card-tag">' . $escapedTag . '</span>';
            }
            $tagHtml = '<div class="link-card-tags">' . implode(' ', $tagParts) . '</div>';
        }

        $metaHtml = '';
        if (!empty($this->metadata)) {
            $metaParts = [];
            foreach ($this->metadata as $key => $value) {
                $escapedKey = $this->escapeHtml((string)$key);
                $escapedValue = $this->escapeHtml((string)$value);
                $metaParts[] = '<span class="link-card-meta-item">' . $escapedKey . ': ' . $escapedValue . '</span>';
            }
            $metaHtml = '<div class="link-card-meta">' . implode(' | ', $metaParts) . '</div>';
        }

        $html = '<div class="link-card">' . "\n";
        $html .= '    <a href="' . $escapedUrl . '" class="link-card-link" target="_blank" rel="noopener noreferrer">' . "\n";
        $html .= '        <div class="link-card-content">' . "\n";
        $html .= '            <h3 class="link-card-title">' . $escapedTitle . '</h3>' . "\n";
        $html .= '            <p class="link-card-description">' . $escapedDescription . '</p>' . "\n";
        $html .= '            ' . $tagHtml . "\n";
        $html .= '            ' . $metaHtml . "\n";
        $html .= '        </div>' . "\n";
        $html .= '    </a>' . "\n";
        $html .= '</div>';

        return $html;
    }

    public static function createFromArray(array $data): self
    {
        $card = new self();
        if (isset($data['title'])) {
            $card->setTitle($data['title']);
        }
        if (isset($data['url'])) {
            $card->setUrl($data['url']);
        }
        if (isset($data['description'])) {
            $card->setDescription($data['description']);
        }
        if (isset($data['tags']) && is_array($data['tags'])) {
            foreach ($data['tags'] as $tag) {
                $card->addTag($tag);
            }
        }
        if (isset($data['metadata']) && is_array($data['metadata'])) {
            $card->setMetadata($data['metadata']);
        }
        return $card;
    }
}

function renderLinkCard(string $title = '爱游戏', string $url = 'https://i-game-home.com.cn', string $description = '探索精彩游戏世界', array $tags = ['游戏', '娱乐', '社区'], array $metadata = []): string
{
    $config = [
        'title' => $title,
        'url' => $url,
        'description' => $description,
        'tags' => $tags,
        'metadata' => $metadata,
    ];

    $card = LinkCard::createFromArray($config);
    return $card->render();
}