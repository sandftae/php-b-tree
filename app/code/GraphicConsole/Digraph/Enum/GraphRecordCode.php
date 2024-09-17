<?php

declare(strict_types=1);

namespace Play\Hard\Code\GraphicConsole\Digraph\Enum;

/**
 * @enum GraphRecordCode
 *
 * @package Play\Hard\Code\GraphicConsole\Digraph\Enum
 */
enum GraphRecordCode: string
{
    /** @case the leftmost key of the node */
    case LEFTMOST_KEY_NODE_CODE = 'key_leftmost';

    /** @case the rightmost key of the node */
    case RIGHTMOST_KEY_NODE_CODE = 'key_rightmost';

    /** @case the left node pointer */
    case LEFT_POINTER_CODE = 'pointer_left';

    /** @case the right node pointer */
    case RIGHT_POINTER_CODE = 'pointer_right';

    /** @case between node pointer */
    case BETWEEN_POINTER_CODE = 'between_keys';
}