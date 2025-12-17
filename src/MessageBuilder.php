<?php

namespace Heysender;

use Heysender\Enums\AnonymizeOptions;

class MessageBuilder
{
    private array $data = [];

    /**
     * Initialize the MessageBuilder
     *
     * @param string $fromEmail Sender email
     * @param string $fromName Sender name
     * @param string $subject Subject line
     * @param string $html Html body
     */
    public function __construct(string $fromEmail, string $fromName, string $subject, string $html)
    {
        $this->data = [
            'from_email' => $fromEmail,
            'from_name' => $fromName,
            'subject' => $subject,
            'html' => $html,
            'to' => [],
            'cc' => [],
            'bcc' => [],
            'attachments' => [],
            'tags' => [],
            'headers' => []
        ];
    }

    /**
     * Set text body on message
     *
     * @param string $text Text body
     * @return self MessageBuilder object
     */
    public function setText(string $text): self
    {
        $this->data['text'] = $text;
        return $this;
    }

    /**
     * Add Recipient email on message
     *
     * @param string $email Recipient email
     * @param string|null $name Recipient name (optional)
     * @return self MessageBuilder object
     */
    public function addTo(string $email, ?string $name = null): self
    {
        $recipient = ['email' => $email];
        if ($name) {
            $recipient['name'] = $name;
        }
        $this->data['to'][] = $recipient;
        return $this;
    }

    /**
     * Add CC email on message
     *
     * @param string $email CC email
     * @param string|null $name Recipient name (optional)
     * @return self MessageBuilder object
     */
    public function addCC(string $email, ?string $name = null): self
    {
        $recipient = ['email' => $email];
        if ($name) {
            $recipient['name'] = $name;
        }
        $this->data['cc'][] = $recipient;
        return $this;
    }

    /**
     * Add BCC email on message
     *
     * @param string $email BCC email
     * @return self MessageBuilder object
     */
    public function addBCC(string $email): self
    {
        $this->data['bcc'][] = $email;
        return $this;
    }

    /**
     * Set reply to email on message
     *
     * @param string $replyTo Reply to email
     * @return self MessageBuilder object
     */
    public function setReplyTo(string $replyTo): self
    {
        $this->data['reply_to'] = $replyTo;
        return $this;
    }

    /**
     * Add attachment to message
     *
     * @param string $name Attachment name
     * @param string $base64Content Attachment content base64 encoded
     * @return self MessageBuilder object
     */
    public function addAttachment(string $name, string $base64Content): self
    {
        $this->data['attachments'][] = [
            'name' => $name,
            'content' => $base64Content
        ];
        return $this;
    }

    /**
     * Add custom tag to message
     *
     * @param string $key Tag key
     * @param string $value Tag value
     * @return self MessageBuilder object
     */
    public function addTag(string $key, string $value): self
    {
        $this->data['tags'][] = [
            'key' => $key,
            'value' => $value
        ];
        return $this;
    }

    /**
     * Add custom header to message
     *
     * @param string $key Header key
     * @param string $value Header value
     * @return self MessageBuilder object
     */
    public function addHeader(string $key, string $value): self
    {
        $this->data['headers'][] = [
            'key' => $key,
            'value' => $value
        ];
        return $this;
    }

    /**
     * Set custom content on message
     *
     * @param array $customContent Custom Content
     * @return self MessageBuilder object
     */
    public function setCustomContent(array $customContent): self
    {
        $this->data['custom_content'] = $customContent;
        return $this;
    }

    /**
     * Activate tracking on message
     *
     * @param bool $enabled Enable/disable tracking
     * @return self MessageBuilder object
     */
    public function setTracking(bool $enabled): self
    {
        $this->data['tracking'] = $enabled;
        return $this;
    }

    /**
     * Set list_unsubscribe header on message
     *
     * @param bool $enabled Enable/disable list_unsubscribe header
     * @return self MessageBuilder object
     */
    public function setListUnsubscribe(bool $enabled): self
    {
        $this->data['list_unsubscribe'] = $enabled;
        return $this;
    }

    /**
     * Set retention time on message
     *
     * @param int $days Amount of days
     * @return self MessageBuilder object
     */
    public function setRetentionTime(int $days): self
    {
        $this->data['retention_time'] = $days;
        return $this;
    }

    /**
     * Set anonymize options on message
     *
     * @param array $options Anonymize options
     * @return self MessageBuilder object
     */
    public function setAnonymizeOptions(array $options): self
    {
        $AnonymizeStrings = array_map(
            fn($option) => $option instanceof AnonymizeOptions ? $option->value : $option,
            $options
        );

        foreach (AnonymizeOptions::values() as $option) {
            $data[$option] = in_array($option, $AnonymizeStrings);
        }

        $this->data['anonymize_options'] = $options;
        return $this;
    }

    /**
     * Set webhook on message
     *
     * @param string $url Webhook URL
     * @param string $events Domain name
     * @return self MessageBuilder object
     */
    public function setWebhook(string $url, array $events): self
    {
        $this->data['webhook'] = [
            'url' => $url,
            'events' => $events
        ];
        return $this;
    }

    /**
     * Build message
     *
     * @return array Created message
     */
    public function build(): array
    {
        return $this->data;
    }
}
