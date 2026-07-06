#!/bin/bash

# Auto Git Push - Per File, 1 commit per file
# Usage: ./amend.sh "commit message"

COMMIT_MSG="${1:-auto update}"
BRANCH=$(git rev-parse --abbrev-ref HEAD 2>/dev/null || echo "main")

echo "🚀 Auto Git Push with Loop Date"
echo "=========================================="
echo " Branch  : $BRANCH"
echo " Message : $COMMIT_MSG"
echo "=========================================="

if ! git rev-parse --git-dir > /dev/null 2>&1; then
    echo "❌ Not a git repository!"
    exit 1
fi

echo "🔍 Repository status:"
git status --short
echo ""

COUNT=0

# Date configuration for amended commits.
# Change these values if you want a different synthetic date range.
AMEND_YEAR=2026
AMEND_MONTH=7
AMEND_START_DAY=2
AMEND_END_DAY=31
AMEND_HOUR=10
AMEND_MINUTE=00
AMEND_SECOND=00

CURRENT_DAY=$AMEND_START_DAY

# ── Detect commit type from filename / path ──────────────────────────────────
get_type() {
    local file="$1"
    local status="$2"

    case "$status" in
        D) echo "delete" ; return ;;
    esac

    # Path-based heuristics
    if [[ "$file" == *.sol ]];                        then echo "feat"     ; return; fi
    if [[ "$file" == *test* || "$file" == *spec* ]];  then echo "test"     ; return; fi
    if [[ "$file" == *.md ]];                         then echo "docs"     ; return; fi
    if [[ "$file" == *.env* || "$file" == *.toml || "$file" == *.json || "$file" == *.yaml || "$file" == *.yml ]]; then
                                                       echo "chore"    ; return; fi
    if [[ "$file" == *style* || "$file" == *.css ]];  then echo "style"    ; return; fi
    if [[ "$file" == *config* ]];                     then echo "chore"    ; return; fi
    if [[ "$file" == *refactor* ]];                   then echo "refactor" ; return; fi

    # Status-based fallback
    case "$status" in
        A|"??") echo "feat"   ;;
        M)      echo "refactor" ;;
        *)      echo "chore"  ;;
    esac
}

# ── Process all changed files (no subshell — uses process substitution) ──────
while IFS= read -r line; do
    [[ -z "$line" ]] && continue

    STATUS="${line:0:2}"
    FILE="${line:3}"

    # Trim leading space from status
    STATUS_CLEAN="${STATUS// /}"

    TYPE=$(get_type "$FILE" "$STATUS_CLEAN")

    case "$STATUS_CLEAN" in
        D)
            echo " delete  → $FILE"
            git rm --cached "$FILE" 2>/dev/null || git rm "$FILE" 2>/dev/null
            git commit -m "$TYPE($FILE): $COMMIT_MSG"
            ;;
        M)
            echo " modify  → $FILE"
            git add "$FILE"
            git commit -m "$TYPE($FILE): $COMMIT_MSG"
            ;;
        A|"??")
            echo " add     → $FILE"
            git add "$FILE"
            git commit -m "$TYPE($FILE): $COMMIT_MSG"
            ;;
        R*)
            # Renamed: "old -> new"
            echo " rename  → $FILE"
            git add "$FILE"
            git commit -m "refactor($FILE): rename - $COMMIT_MSG"
            ;;
        *)
            echo " $STATUS_CLEAN → $FILE"
            git add "$FILE"
            git commit -m "chore($FILE): $COMMIT_MSG"
            ;;
    esac

    # Build the amended commit date from the config block above.
    COMMIT_DATE=$(printf "%04d-%02d-%02d %02d:%02d:%02d" \
        "$AMEND_YEAR" \
        "$AMEND_MONTH" \
        "$CURRENT_DAY" \
        "$AMEND_HOUR" \
        "$AMEND_MINUTE" \
        "$AMEND_SECOND")
    
    echo " amending date → $COMMIT_DATE"
    git commit --amend --no-edit --date="$COMMIT_DATE" > /dev/null

    # Increment day and loop back to the start of the configured range.
    CURRENT_DAY=$((CURRENT_DAY + 1))
    if [ "$CURRENT_DAY" -gt "$AMEND_END_DAY" ]; then
        CURRENT_DAY=$AMEND_START_DAY
    fi

    COUNT=$((COUNT + 1))

done < <(git status --short)

# ── Push ─────────────────────────────────────────────────────────────────────
echo ""

# Check if there are local commits to push
LOCAL_AHEAD=$(git rev-list --count origin/"$BRANCH".."$BRANCH" 2>/dev/null || echo "0")

if [ "$COUNT" -gt 0 ] || [ "$LOCAL_AHEAD" -gt 0 ]; then
    if [ "$LOCAL_AHEAD" -gt 0 ]; then
        echo "📤 Local branch is ahead by $LOCAL_AHEAD commit(s)."
    fi
    echo "📤 Pushing to origin/$BRANCH..."
    if git push origin "$BRANCH"; then
        echo "=========================================="
        echo "✅ Done! $COUNT commit(s) pushed."
        echo "=========================================="
    else
        echo "=========================================="
        echo "❌ Push failed!"
        echo "=========================================="
        exit 1
    fi
else
    echo "=========================================="
    echo " Nothing to commit. Working tree clean."
    echo "=========================================="
fi