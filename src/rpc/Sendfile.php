<?php

namespace iboxs\swoole\rpc;

trait Sendfile
{
    protected function fread(\iboxs\File $file)
    {
        try {
            $handle = fopen($file->getPathname(), 'rb');
            yield pack(Packer::HEADER_PACK, $file->getSize(), Packer::TYPE_FILE);
            while (!feof($handle)) {
                yield fread($handle, 8192);
            }
        } finally {
            fclose($handle);
        }
    }
}
